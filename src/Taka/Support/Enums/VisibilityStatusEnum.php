<?php

declare(strict_types=1);

namespace Taka\Support\Enums;

use Taka\Support\EnumTrait;

enum VisibilityStatusEnum: string
{
    use EnumTrait;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
