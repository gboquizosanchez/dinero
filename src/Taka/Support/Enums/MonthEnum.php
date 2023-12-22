<?php

declare(strict_types=1);

namespace Taka\Support\Enums;

use Taka\Support\EnumTrait;

enum MonthEnum: string
{
    use EnumTrait;

    case JANUARY = 'january';
    case FEBRUARY = 'february';
    case MARCH = 'march';
    case APRIL = 'april';
    case MAY = 'may';
    case JUNE = 'june';
    case JULY = 'july';
    case AUGUST = 'august';
    case SEPTEMBER = 'september';
    case OCTOBER = 'october';
    case NOVEMBER = 'november';
    case DECEMBER = 'december';

    public static function toArray(): array
    {
        return array_map(function ($value) {
            return $value();
        }, self::cases());
    }
}
