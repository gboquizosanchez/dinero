<?php

declare(strict_types=1);

namespace Filament\Resources\DebtResource\Pages;

use Filament\Actions;
use Filament\Resources\DebtResource;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditDebt extends EditRecord
{
    protected static string $resource = DebtResource::class;

    #[Override]
    public function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
