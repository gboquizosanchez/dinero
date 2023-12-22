<?php

declare(strict_types=1);

namespace Taka\Support\Enums;

use Taka\Support\EnumTrait;

/**
 * @method static string DEPOSIT()
 * @method static string WITHDRAW()
 * @method static string TRANSFER()
 * @method static string PAYMENT()
 */
enum TransactionTypeEnum: string
{
    use EnumTrait;

    case DEPOSIT = 'deposit';
    case WITHDRAW = 'withdraw';
    case TRANSFER = 'transfer';
    case PAYMENT = 'payment';

    public static function toArray(): array
    {
        return array_map(function ($value) {
            return $value();
        }, self::cases());
    }

    public static function toArrayExcept($except): array
    {
        return array_filter(array_map(function ($value) use ($except) {
            if (in_array($value(), $except)) {
                return null;
            }

            return $value();
        }, self::cases()));
    }
}
