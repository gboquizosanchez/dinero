<?php

declare(strict_types=1);

namespace Taka\Support\Enums;

use Taka\Support\EnumTrait;

/**
 * @method static string GENERAL()
 * @method static string CREDIT_CARD()
 */
enum WalletTypeEnum: string
{
    use EnumTrait;

    case GENERAL = 'general';
    case CREDIT_CARD = 'credit_card';
}
