<?php

declare(strict_types=1);

namespace Filament\Resources\WalletResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\WalletResource;

final class CreateWallet extends CreateRecord
{
    protected static string $resource = WalletResource::class;
}
