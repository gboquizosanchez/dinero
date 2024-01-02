<?php

declare(strict_types=1);

namespace Filament\Resources\WalletResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\WalletResource;
use Override;

final class ListWallets extends ListRecords
{
    protected static string $resource = WalletResource::class;

    #[Override]
    public function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
