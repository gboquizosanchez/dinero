<?php

declare(strict_types=1);

namespace Taka\Support\Enums;

use Taka\Support\EnumTrait;

/**
 * @method static string INCOME()
 * @method static string EXPENSE()
 */
enum SpendTypeEnum: string
{
    use EnumTrait;

    case INCOME = 'income';
    case EXPENSE = 'expense';

    public static function toArray(): array
    {
        return array_map(function ($value) {
            return $value();
        }, self::cases());
    }
}
