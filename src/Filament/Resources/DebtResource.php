<?php

declare(strict_types=1);

namespace Filament\Resources;

use Awcodes\FilamentBadgeableColumn\Components\Badge;
use Awcodes\FilamentBadgeableColumn\Components\BadgeableColumn;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\DebtResource\Pages;
use Filament\Resources\DebtResource\RelationManagers\TransactionsRelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Override;
use Taka\Domain\Models\Debt;
use Taka\Support\Enums\DebtTypeEnum;

final class DebtResource extends Resource
{
    protected static ?string $model = Debt::class;

    protected static ?string $navigationIcon = 'helping-hand';

    protected static ?int $navigationSort = 500;

    #[Override]
    public static function getNavigationLabel(): string
    {
        return __('debts.title');
    }

    #[Override]
    public static function getModelLabel(): string
    {
        return __('debts.title_singular');
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
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Radio::make('type')
                            ->label(__('debts.fields.type'))
                            ->options(__('debts.types'))
                            ->inline()
                            ->default(DebtTypeEnum::PAYABLE())
                            ->required(),
                        TextInput::make('name')
                            ->label(__('debts.fields.name'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('amount')
                            ->label(__('debts.fields.amount'))
                            ->required()
                            ->numeric()
                            ->default(0.00),
                        Select::make('wallet_id')
                            ->label(__('debts.fields.wallet'))
                            ->relationship('wallet', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        DateTimePicker::make('start_at')
                            ->label(__('debts.fields.start_at'))
                            ->default(now()),
                        ColorPicker::make('color')
                            ->label(__('debts.fields.color')),
                        Textarea::make('description')
                            ->label(__('debts.fields.description'))
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])->columns(),
            ]);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ColorColumn::make('color')
                    ->label(__('debts.fields.color')),
                TextColumn::make('type')
                    ->badge()
                    ->color(function (string $state) {
                        return match ($state) {
                            DebtTypeEnum::PAYABLE() => 'danger',
                            DebtTypeEnum::RECEIVABLE() => 'success',
                        };
                    })
                    ->formatStateUsing(fn (string $state) => __('debts.types.' . $state))
                    ->label(__('debts.fields.type'))
                    ->sortable(),
                TextColumn::make('name')
                    ->label(__('debts.fields.name'))
                    ->searchable(),
                TextColumn::make('total_debt_amount')
                    ->label(__('debts.fields.total_debt_amount'))
                    ->numeric()
                    ->sortable(),
                BadgeableColumn::make('balance')
                    ->label(__('goals.fields.balance'))
                    ->suffixBadges([
                        Badge::make('progress')
                            ->label(fn (Model $record) => $record->progress . '%'),
                    ]),
                TextColumn::make('wallet.name')
                    ->label(__('debts.fields.initial_wallet'))
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('start_at')
                    ->label(__('debts.fields.start_at'))
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('description')
                    ->limit(20)
                    ->searchable()
                    ->label(__('debts.fields.description')),
            ])
            ->filters([

            ])
            ->actions([
                Action::make('deposit')
                    ->label(__('debts.actions.debt_transaction'))
                    ->color('danger')
                    ->icon('lucide-trending-up')
                    ->form(function (Debt $debt) {
                        return (new Pages\ListDebts())->getDebtTransactionFields(debtId: $debt->id);
                    })
                    ->action(function (array $data) {
                        (new Pages\ListDebts())->makeDebtTransaction($data);
                    })
                    ->visible(fn (Debt $debt) => $debt->progress < 100),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
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
            'index' => Pages\ListDebts::route('/'),
            'edit' => Pages\EditDebt::route('/{record}/edit'),
        ];
    }
}
