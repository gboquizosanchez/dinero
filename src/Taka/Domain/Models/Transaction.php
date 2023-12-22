<?php

declare(strict_types=1);

namespace Taka\Domain\Models;

use Bavix\Wallet\Internal\Service\UuidFactoryServiceInterface;
use Bavix\Wallet\Models\Transaction as BavixTransaction;
use Database\Factories\TransactionFactory;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shipu\Watchable\Traits\WatchableTrait;
use Taka\Support\Enums\SpendTypeEnum;
use Taka\Support\Enums\TransactionTypeEnum;

/**
 * @mixin IdeHelperTransaction
 */
final class Transaction extends BavixTransaction
{
    use HasFactory;
    use SoftDeletes;
    use WatchableTrait;

    /** @var array<int, string> */
    protected $fillable = [
        'payable_type',
        'payable_id',
        'reference_type',
        'reference_id',
        'wallet_id',
        'uuid',
        'type',
        'amount',
        'confirmed',
        'meta',
        'category_id',
        'account_id',
        'happened_at',
        'created_at',
        'updated_at',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'wallet_id' => 'int',
        'confirmed' => 'bool',
        'meta' => 'array',
        'happened_at' => 'datetime',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeTenant(Builder $query): Builder
    {
        return $query->where('account_id', Filament::getTenant()?->id);
    }

    public function wallet(): BelongsTo
    {
        $filamentTenantId = Filament::getTenant()?->id;
        $relationShip = $this->belongsTo(Wallet::class);

        if (! blank($filamentTenantId)) {
            return $relationShip->where('account_id', $filamentTenantId);
        }

        return $relationShip;
    }

    public function onModelCreating(): void
    {
        if (blank($this->payable_id) && filled($user = auth()->user())) {
            $this->payable_type = User::class;
            $this->payable_id = $user->id;
        }

        if (blank($this->uuid)) {
            $this->uuid = app(UuidFactoryServiceInterface::class)->uuid4();
        }

        $this->type = match (optional($this->category)->type) {
            SpendTypeEnum::EXPENSE() => TransactionTypeEnum::WITHDRAW(),
            SpendTypeEnum::INCOME() => TransactionTypeEnum::DEPOSIT(),
            default => $this->type,
        };
    }

    public function onModelSaving(): void
    {
        if (in_array($this->type, [TransactionTypeEnum::TRANSFER(), TransactionTypeEnum::PAYMENT()])) {
            $this->type = $this->getOriginal('type');
        }
        $this->meta = array_merge(($this->getOriginal('meta') ?? []), $this->meta ?? []);
    }

    public function isTransferTransaction(): Attribute
    {
        return Attribute::get(function () {
            return array_get($this->meta, 'transfer', false) ?? false;
        });
    }

    public function isPaymentTransaction(): Attribute
    {
        return Attribute::get(function () {
            return array_get($this->meta, 'payment', false) ?? false;
        });
    }

    public function onModelSaved(): void
    {
        $this->wallet?->refreshBalance();
    }

    public static function newFactory(): TransactionFactory
    {
        return TransactionFactory::new();
    }
}
