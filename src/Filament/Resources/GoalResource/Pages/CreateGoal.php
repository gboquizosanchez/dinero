<?php

declare(strict_types=1);

namespace Filament\Resources\GoalResource\Pages;

use Filament\Resources\GoalResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateGoal extends CreateRecord
{
    protected static string $resource = GoalResource::class;
}
