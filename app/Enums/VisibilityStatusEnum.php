<?php

declare(strict_types=1);

namespace App\Enums;

enum VisibilityStatusEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
