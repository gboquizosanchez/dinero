<?php

declare(strict_types=1);

namespace Taka\Support\Enums;

use Taka\Support\EnumTrait;

/**
 * @method static string ACTIVE()
 * @method static string INACTIVE()
 */
enum VisibilityStatusEnum: string
{
    use EnumTrait;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
