<?php

declare(strict_types=1);

namespace Filament\Resources\WalletResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Filament\Resources\WalletResource;
use Illuminate\Database\Eloquent\Builder;
use Taka\Domain\Models\Wallet;
use Taka\Support\Enums\WalletTypeEnum;

class ListWallets extends ListRecords
{
    protected static string $resource = WalletResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->icon('lucide-wallet')
                ->badge(Wallet::tenant()->count()),
            WalletTypeEnum::GENERAL() => Tab::make()
                ->icon('badge-dollar-sign')
                ->badge(Wallet::tenant()->where('type', WalletTypeEnum::GENERAL())->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->tenant()->where('type', WalletTypeEnum::GENERAL())),
            WalletTypeEnum::CREDIT_CARD() => Tab::make()
                ->icon('lucide-credit-card')
                ->badge(Wallet::tenant()->where('type', WalletTypeEnum::CREDIT_CARD())->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->tenant()->where('type', WalletTypeEnum::CREDIT_CARD())),
        ];
    }
}
