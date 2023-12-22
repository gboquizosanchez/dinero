<?php

declare(strict_types=1);

namespace Taka\Domain\Models;

use Database\Factories\AccountFactory;
use Filament\Models\Contracts\HasCurrentTenantLabel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Model;
use Override;

/**
 * @mixin IdeHelperAccount
 */
final class Account extends Model implements HasCurrentTenantLabel
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    /** @var array<int, string> */
    protected $fillable = [
        'name',
        'owner_id',
    ];

    #[Override]
    public function uniqueIds(): array
    {
        return [
            'id',
        ];
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }

    public function getCurrentTenantLabel(): string
    {
        return 'Selected account';
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'account_member',
            'account_id',
            'user_id',
        )
            ->using(Member::class);
    }

    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class);
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    public function debts(): HasMany
    {
        return $this->hasMany(Debt::class);
    }

    public static function newFactory(): AccountFactory
    {
        return AccountFactory::new();
    }
}
