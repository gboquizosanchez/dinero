<?php

declare(strict_types=1);

namespace Filament\Resources\TransactionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\TransactionResource;
use Override;

final class EditTransaction extends EditRecord
{
    protected static string $resource = TransactionResource::class;

    #[Override]
    public function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    #[Override]
    public function mutateFormDataBeforeSave(array $data): array
    {
        $data['amount'] *= 100;

        return $data;
    }
}
