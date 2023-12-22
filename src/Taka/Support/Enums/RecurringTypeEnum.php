<?php

declare(strict_types=1);

namespace Taka\Support\Enums;

use Taka\Support\EnumTrait;

/**
 * @method static string NONE()
 * @method static string DAILY()
 * @method static string WEEKLY()
 * @method static string MONTHLY()
 * @method static string YEARLY()
 */
enum RecurringTypeEnum: string
{
    use EnumTrait;

    case NONE = 'none';
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';

    public static function toArray(): array
    {
        return array_map(function ($value) {
            return $value();
        }, self::cases());
    }
}
