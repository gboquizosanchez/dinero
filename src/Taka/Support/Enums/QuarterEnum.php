<?php

declare(strict_types=1);

namespace Taka\Support\Enums;

use Taka\Support\EnumTrait;

/**
 * @method static string FIRST_MONTH()
 * @method static string SECOND_MONTH()
 * @method static string THIRD_MONTH()
 */
enum QuarterEnum: string
{
    use EnumTrait;

    case FIRST_MONTH = 'first_month';
    case SECOND_MONTH = 'second_month';
    case THIRD_MONTH = 'third_month';

    public static function toArray(): array
    {
        return array_map(function ($value) {
            return $value();
        }, self::cases());
    }
}
