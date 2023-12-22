<?php

declare(strict_types=1);

namespace Filament\Resources\BudgetResource\Pages;

use Filament\Actions;
use Filament\Resources\BudgetResource;
use Filament\Resources\Pages\ListRecords;
use Override;

final class ListBudgets extends ListRecords
{
    protected static string $resource = BudgetResource::class;

    #[Override]
    public function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
