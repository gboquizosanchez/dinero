<?php

declare(strict_types=1);

namespace Filament\Resources\TransactionResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\TransactionResource;
use Illuminate\Database\Eloquent\Builder;
use Override;
use Taka\Domain\Models\Transaction;
use Taka\Support\Enums\TransactionTypeEnum;

final class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    #[Override]
    public function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    #[Override]
    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->icon('lucide-calculator')
                ->badge(Transaction::tenant()->count()),
            TransactionTypeEnum::WITHDRAW() => Tab::make()
                ->icon('lucide-trending-down')
                ->badge(Transaction::tenant()->where('type', TransactionTypeEnum::WITHDRAW())->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', TransactionTypeEnum::WITHDRAW())),
            TransactionTypeEnum::DEPOSIT() => Tab::make()
                ->icon('lucide-trending-up')
                ->badge(Transaction::tenant()->where('type', TransactionTypeEnum::DEPOSIT())->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', TransactionTypeEnum::DEPOSIT())),
        ];
    }
}
