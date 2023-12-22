<?php

declare(strict_types=1);

namespace Filament\Resources\DebtResource\Pages;

use Filament\Resources\DebtResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateDebt extends CreateRecord
{
    protected static string $resource = DebtResource::class;
}
