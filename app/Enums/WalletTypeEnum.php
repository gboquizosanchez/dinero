<?php

declare(strict_types=1);

namespace App\Enums;

enum WalletTypeEnum: string
{
    case GENERAL = 'general';
    case CREDIT_CARD = 'credit_card';
}
