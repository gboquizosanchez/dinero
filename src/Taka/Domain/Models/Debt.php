<?php

declare(strict_types=1);

namespace Taka\Domain\Models;

use Database\Factories\DebtFactory;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Model;
use Shipu\Watchable\Traits\WatchableTrait;
use Taka\Support\Enums\DebtTypeEnum;
use Taka\Support\Enums\TransactionTypeEnum;

/**
 * @mixin IdeHelperDebt
 */
final class Debt extends Model
{
    use HasFactory;
    use SoftDeletes;
    use WatchableTrait;

    /** @var array<int, string> */
    protected $fillable = [
        'name',
        'type',
        'amount',
        'description',
        'start_at',
        'account_id',
        'wallet_id',
        'color',
    ];

    public function progress(): Attribute
    {
        return Attribute::get(function () {
            if ($this->total_debt_amount == 0) {
                return 100;
            }

            return number_format(($this->balance / $this->total_debt_amount) * 100, 2);
        });
    }

    public function totalDebtAmount(): Attribute
    {
        return Attribute::get(function () {
            $query = $this->transactions();

            return match ($this->type) {
                DebtTypeEnum::PAYABLE() => $query->where('type', '<>', TransactionTypeEnum::WITHDRAW())->sum('amount'),
                DebtTypeEnum::RECEIVABLE() => $query->where('type', '<>', TransactionTypeEnum::DEPOSIT())->sum('amount') * -1,
            };
        });
    }

    public function balance(): Attribute
    {
        return Attribute::get(function () {
            $query = $this->transactions->whereNotNull('wallet_id');

            $query = match ($this->type) {
                DebtTypeEnum::PAYABLE() => $query->where('type', TransactionTypeEnum::WITHDRAW()),
                DebtTypeEnum::RECEIVABLE() => $query->where('type', TransactionTypeEnum::DEPOSIT()),
            };

            return match ($this->type) {
                DebtTypeEnum::PAYABLE() => $query->sum('amount') * -1,
                DebtTypeEnum::RECEIVABLE() => $query->sum('amount'),
            };
        });
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function scopeTenant(Builder $query): Builder
    {
        return $query->where('account_id', Filament::getTenant()?->id);
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'reference');
    }

    public function onModelCreated(): void
    {
        $meta = ['reference_type' => self::class, 'reference_id' => $this->id, 'account_id' => $this->account_id];
        $method = match ($this->type) {
            DebtTypeEnum::RECEIVABLE() => 'withdraw',
            DebtTypeEnum::PAYABLE() => 'deposit',
            default => null,
        };

        if (! blank($method)) {
            $this->wallet->{$method}($this->amount * 100, $meta);
        }
    }

    public function onModelUpdating(): void
    {
        $meta = ['reference_type' => self::class, 'reference_id' => $this->id];
        $delta = $this->amount - $this->getOriginal('amount');
        $method = null;

        if ($delta > 0) {
            $method = $this->type == DebtTypeEnum::RECEIVABLE() ? 'withdraw' : 'deposit';
        } elseif ($delta != 0) {
            $delta = abs($delta);
            $method = $this->type == DebtTypeEnum::RECEIVABLE() ? 'deposit' : 'withdraw';
        }

        if (! blank($method)) {
            $this->wallet->{$method}($delta * 100, $meta);
        }
    }

    public static function newFactory(): DebtFactory
    {
        return DebtFactory::new();
    }
}
