<?php

declare(strict_types=1);

namespace Filament\Resources\CategoryResource\Pages;

use Filament\Actions;
use Filament\Resources\CategoryResource;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

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
