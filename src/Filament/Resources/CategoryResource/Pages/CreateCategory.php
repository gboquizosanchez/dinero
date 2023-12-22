<?php

declare(strict_types=1);

namespace Filament\Resources\CategoryResource\Pages;

use Filament\Resources\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
}
