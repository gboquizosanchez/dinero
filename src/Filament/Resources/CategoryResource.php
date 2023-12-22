<?php

declare(strict_types=1);

namespace Filament\Resources;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\CategoryResource\Pages;
use Filament\Resources\CategoryResource\RelationManagers\TransactionsRelationManager;
use Filament\Tables;
use Filament\Tables\Columns\IconColorColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Guava\FilamentIconPicker\Forms\IconPicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Override;
use Taka\Domain\Models\Category;
use Taka\Support\Enums\SpendTypeEnum;
use Taka\Support\Enums\VisibilityStatusEnum;

final class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'lucide-layout-list';

    protected static ?int $navigationSort = 200;

    #[Override]
    public static function getNavigationLabel(): string
    {
        return __('categories.title');
    }

    #[Override]
    public static function getModelLabel(): string
    {
        return __('categories.title_singular');
    }

    #[Override]
    public static function getPluralLabel(): ?string
    {
        return self::getNavigationLabel();
    }

    #[Override]
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns(2)
                    ->schema([
                        Radio::make('type')
                            ->label(__('categories.fields.type'))
                            ->columnSpan([
                                'sm' => 2,
                            ])
                            ->options(collect(__('categories.types'))->pluck('label', 'id')->reverse())
                            ->inline()
                            ->default(SpendTypeEnum::EXPENSE())
                            ->required(),
                        TextInput::make('name')
                            ->label(__('categories.fields.name'))
                            ->required()
                            ->maxLength(255),
                        ColorPicker::make('color')
                            ->label(__('categories.fields.color'))
                            ->default('#22b3e0'),
                        IconPicker::make('icon')
                            ->label(__('categories.fields.icon'))
//                            ->sets(['lucide-icons'])
                            ->sets(['heroicons', 'fontawesome-solid'])
                            ->columnSpan([
                                'sm' => 2,
                            ])
                            ->preload()
                            ->columns([
                                'default' => 1,
                                'lg' => 3,
                                '2xl' => 5,
                            ]),
                        Toggle::make('status')
                            ->label(__('categories.fields.is_visible'))
                            ->default(VisibilityStatusEnum::ACTIVE())
                            ->helperText(__('categories.fields.is_visible_help_text'))
                            ->afterStateHydrated(function (Toggle $component, string $state) {
                                $component->state($state == VisibilityStatusEnum::ACTIVE());
                            })
                            ->dehydrateStateUsing(fn (string $state): string => $state ? VisibilityStatusEnum::ACTIVE() : VisibilityStatusEnum::INACTIVE()),
                    ]),
            ]);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                IconColorColumn::make('icon')
                    ->label(__('categories.fields.icon')),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('categories.fields.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('categories.fields.type'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        SpendTypeEnum::EXPENSE() => 'warning',
                        SpendTypeEnum::INCOME() => 'primary',
                    })
                    ->formatStateUsing(fn (string $state): string => __("categories.types.{$state}.label"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('monthly_balance')
                    ->label(__('categories.fields.monthly_balance')),
                Tables\Columns\IconColumn::make('status')
                    ->label(__('categories.fields.is_visible'))
                    ->icon(fn (string $state): string => match ($state) {
                        VisibilityStatusEnum::ACTIVE() => 'lucide-check-circle',
                        VisibilityStatusEnum::INACTIVE() => 'lucide-x-circle',
                        default => 'lucide-x-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        VisibilityStatusEnum::ACTIVE() => 'success',
                        VisibilityStatusEnum::INACTIVE() => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->deferLoading()
            ->filters([
                Filter::make('status')
                    ->label(__('categories.fields.is_visible'))
                    ->query(fn (Builder $query): Builder => $query->where('status', VisibilityStatusEnum::ACTIVE->value))
                    ->toggle(),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->reorderable('order')
            ->defaultSort('order')
            ->deferLoading()
            ->striped()
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    #[Override]
    public static function getRelations(): array
    {
        return [
            TransactionsRelationManager::class,
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    #[Override]
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
