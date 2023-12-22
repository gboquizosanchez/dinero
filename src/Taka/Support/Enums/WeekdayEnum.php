<?php

declare(strict_types=1);

namespace Taka\Support\Enums;

use Taka\Support\EnumTrait;

enum WeekdayEnum: string
{
    use EnumTrait;

    case SUNDAY = 'sunday';
    case MONDAY = 'monday';
    case TUESDAY = 'tuesday';
    case WEDNESDAY = 'wednesday';
    case THURSDAY = 'thursday';
    case FRIDAY = 'friday';
    case SATURDAY = 'saturday';

    public static function toArray(): array
    {
        return array_map(function ($value) {
            return $value();
        }, self::cases());
    }
}
