<?php

declare(strict_types=1);

namespace Taka\Domain\Models;

use Laravel\Model;

/**
 * @mixin IdeHelperAccountMemberInvitation
 */
final class AccountMemberInvitation extends Model
{
    /** @var array<int, string> */
    protected $fillable = [
        'account_id',
        'email',
    ];
}
