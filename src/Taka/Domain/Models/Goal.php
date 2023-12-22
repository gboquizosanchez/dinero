<?php

declare(strict_types=1);

namespace Taka\Domain\Models;

use Database\Factories\GoalFactory;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Model;
use Shipu\Watchable\Traits\WatchableTrait;

/**
 * @mixin IdeHelperGoal
 */
final class Goal extends Model
{
    use HasFactory;
    use WatchableTrait;

    /** @var array<int, string> */
    protected $fillable = [
        'name',
        'amount',
        'target_date',
        'color',
        'currency_code',
    ];

    public function progress(): Attribute
    {
        return Attribute::get(function () {
            if ($this->amount > 0) {
                return ($this->balance / $this->amount) * 100;
            }

            return 0;
        });
    }

    public function balance(): Attribute
    {
        return Attribute::get(function () {
            return $this->transactions->sum('amount_float') * -1;
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

    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'reference');
    }

    public static function newFactory(): GoalFactory
    {
        return GoalFactory::new();
    }
}
