<?php

declare(strict_types=1);

namespace Filament\Resources\BudgetResource\Pages;

use Filament\Actions;
use Filament\Resources\BudgetResource;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditBudget extends EditRecord
{
    protected static string $resource = BudgetResource::class;

    #[Override]
    public function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
