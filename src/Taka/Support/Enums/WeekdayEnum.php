<?php

declare(strict_types=1);

namespace Taka\Support\Enums;

use Taka\Support\EnumTrait;

/**
 * @method static string SUNDAY()
 * @method static string MONDAY()
 * @method static string TUESDAY()
 * @method static string WEDNESDAY()
 * @method static string THURSDAY()
 * @method static string FRIDAY()
 * @method static string SATURDAY()
 */
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
