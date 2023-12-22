<?php

declare(strict_types=1);

namespace Filament\Resources\GoalResource\Pages;

use Filament\Actions;
use Filament\Resources\GoalResource;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditGoal extends EditRecord
{
    protected static string $resource = GoalResource::class;

    #[Override]
    public function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
