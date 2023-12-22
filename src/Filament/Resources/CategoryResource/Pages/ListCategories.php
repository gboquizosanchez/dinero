<?php

declare(strict_types=1);

namespace Filament\Resources\CategoryResource\Pages;

use Filament\Actions;
use Filament\Resources\CategoryResource;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Override;
use Taka\Domain\Models\Category;
use Taka\Support\Enums\SpendTypeEnum;

final class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    #[Override]
    public function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    #[Override]
    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->icon('lucide-layout-list')
                ->badge(Category::tenant()->count()),
            SpendTypeEnum::EXPENSE() => Tab::make()
                ->icon('lucide-trending-down')
                ->badge(Category::tenant()->where('type', SpendTypeEnum::EXPENSE())->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', SpendTypeEnum::EXPENSE())),
            SpendTypeEnum::INCOME() => Tab::make()
                ->icon('lucide-trending-up')
                ->badge(Category::tenant()->where('type', SpendTypeEnum::INCOME())->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', SpendTypeEnum::INCOME())),
        ];
    }
}
