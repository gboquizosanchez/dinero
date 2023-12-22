<?php

declare(strict_types=1);

namespace Taka\Support\Enums;

use Taka\Support\EnumTrait;

/**
 * @method static string PAYABLE()
 * @method static string RECEIVABLE()
 */
enum DebtTypeEnum: string
{
    use EnumTrait;

    case PAYABLE = 'payable';
    case RECEIVABLE = 'receivable';

    public static function toArray(): array
    {
        return array_map(function ($value) {
            return $value();
        }, self::cases());
    }

    public static function toArrayExcept(array $except): array
    {
        return array_filter(array_map(function ($value) use ($except) {
            if (in_array($value(), $except)) {
                return null;
            }

            return $value();
        }, self::cases()));
    }
}
