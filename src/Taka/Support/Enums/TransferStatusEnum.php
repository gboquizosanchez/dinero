<?php

declare(strict_types=1);

namespace Taka\Support\Enums;

use Taka\Support\EnumTrait;

enum TransferStatusEnum: string
{
    use EnumTrait;

    case EXCHANGE = 'exchange';
    case TRANSFER = 'transfer';
    case REFUND = 'refund';
    case GIFT = 'gift';
    case PAID = 'paid';

    public static function toArray(): array
    {
        return array_map(function ($value) {
            return $value();
        }, self::cases());
    }
}
