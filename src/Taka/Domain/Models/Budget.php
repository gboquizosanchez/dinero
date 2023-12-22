<?php

declare(strict_types=1);

namespace Taka\Domain\Models;

use Database\Factories\BudgetFactory;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Model;
use Shipu\Watchable\Traits\WatchableTrait;

/**
 * @mixin IdeHelperBudget
 */
final class Budget extends Model
{
    use HasFactory;
    use SoftDeletes;
    use WatchableTrait;

    /** @var array<int, string> */
    protected $fillable = [
        'name',
        'color',
        'amount',
        'account_id',
        'period',
        'day_of_month',
        'day_of_week',
        'month_of_year',
        'month_of_quarter',
        'status',
    ];

    public function spendAmount(): Attribute
    {
        return Attribute::get(function () {
            return $this->categories->sum('balance');
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

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'budget_category',
            'budget_id',
            'category_id',
        );
    }

    public static function newFactory(): BudgetFactory
    {
        return BudgetFactory::new();
    }
}
