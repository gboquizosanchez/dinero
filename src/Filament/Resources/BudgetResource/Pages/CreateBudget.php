<?php

declare(strict_types=1);

namespace Filament\Resources\BudgetResource\Pages;

use Filament\Resources\BudgetResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateBudget extends CreateRecord
{
    protected static string $resource = BudgetResource::class;
}
