<?php

declare(strict_types=1);

namespace Taka\Domain\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @mixin IdeHelperMember
 */
final class Member extends Pivot
{
    protected $table = 'account_member';

    protected $fillable = [
        'account_id',
        'user_id',
    ];
}
