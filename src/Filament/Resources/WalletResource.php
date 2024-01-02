<?php

declare(strict_types=1);

namespace Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\WalletResource\Pages;
use Filament\Resources\WalletResource\RelationManagers;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Guava\FilamentIconPicker\Forms\IconPicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;
use Override;
use Taka\Domain\Models\Wallet;
use Taka\Support\Enums\WalletTypeEnum;

final class WalletResource extends Resource
{
    protected static ?string $model = Wallet::class;

    protected static ?string $navigationIcon = 'lucide-wallet';

    protected static ?int $navigationSort = 100;

    #[Override]
    public static function getNavigationLabel(): string
    {
        return __('wallets.title');
    }

    #[Override]
    public static function getModelLabel(): string
    {
        return __('wallets.title_singular');
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
                        TextInput::make('name')
                            ->label(__('wallets.fields.name'))
                            ->required()
                            ->unique(static function (Builder $builder) {
                                $builder->whereNull('deleted_at');
                            })
                            ->autofocus()
                            ->columnSpan([
                                'sm' => 1,
                            ]),
                        Select::make('type')
                            ->label(__('wallets.fields.type'))
                            ->columnSpan([
                                'sm' => 1,
                            ])
                            ->searchable()
                            ->required()
                            ->options(__('wallets.types'))
                            ->default(WalletTypeEnum::GENERAL())
                            ->live()
                            ->disabled(static function (string $operation): bool {
                                return $operation !== 'create';
                            }),
                        TextInput::make('balance')
                            ->label(static function (string $operation): string {
                                if ($operation === 'create') {
                                    return __('wallets.fields.initial_balance');
                                }

                                return __('wallets.fields.balance');
                            })
                            ->required()
                            ->numeric()
                            ->inputMode('decimal')
                            ->default(0)
                            ->disabled()
                            ->visible(static function (Get $get, string $operation): bool {
                                return $get('type') === WalletTypeEnum::GENERAL()
                                    && $operation !== 'create';
                            }),
                        TextInput::make('meta.initial_balance')
                            ->label(__('wallets.fields.initial_balance'))
                            ->required()
                            ->numeric()
                            ->columnSpan([
                                'sm' => 2,
                            ])
                            ->inputMode('decimal')
                            ->default(0)
                            ->visible(static function (Get $get, string $operation): bool {
                                return $get('type') === WalletTypeEnum::GENERAL()
                                    && $operation === 'create';
                            }),
                        TextInput::make('meta.credit')
                            ->label(__('wallets.fields.credit_limit'))
                            ->required()
                            ->numeric()
                            ->inputMode('decimal')
                            ->default(0)
                            ->columnSpan(static function (string $operation): int {
                                if ($operation === 'create') {
                                    return 1;
                                }

                                return 2;
                            })
                            ->visible(static function (Get $get): bool {
                                return $get('type') === WalletTypeEnum::CREDIT_CARD();
                            }),
                        TextInput::make('meta.total_due')
                            ->label(__('wallets.fields.total_due'))
                            ->required()
                            ->numeric()
                            ->inputMode('decimal')
                            ->default(0)
                            ->visible(static function (Get $get, string $operation): bool {
                                return $get('type') === WalletTypeEnum::CREDIT_CARD()
                                    && $operation === 'create';
                            }),
                        Select::make('currency_code')
                            ->label(__('wallets.fields.currency_code'))
                            ->required()
                            ->searchable()
                            ->columnSpan([
                                'sm' => 1,
                            ])
                            ->options(country_with_currency_and_symbol())
                            ->default('EUR'),
                        ColorPicker::make('color')
                            ->label(__('wallets.fields.color'))
                            ->required()
                            ->columnSpan([
                                'sm' => 1,
                            ])
                            ->default('#22b3e0'),
                        IconPicker::make('icon')
                            ->label(__('wallets.fields.icon'))
                            ->columnSpan([
                                'sm' => 2,
                            ])
                            ->columns([
                                'default' => 1,
                                'lg' => 3,
                                '2xl' => 5,
                            ]),
                        Select::make('statement_day_of_month')
                            ->label(__('wallets.fields.statement_day_of_month'))
                            ->options(month_ordinal_numbers())
                            ->required()
                            ->visible(static function (Get $get): bool {
                                return $get('type') === WalletTypeEnum::CREDIT_CARD();
                            }),
                        Select::make('payment_due_day_of_month')
                            ->label(__('wallets.fields.payment_due_day_of_month'))
                            ->options(month_ordinal_numbers())
                            ->required()
                            ->visible(static function (Get $get): bool {
                                return $get('type') === WalletTypeEnum::CREDIT_CARD();
                            }),
                        Forms\Components\Toggle::make('exclude')
                            ->label(__('wallets.fields.exclude.title'))
                            ->helperText(__('wallets.fields.exclude.help_text'))
                            ->default(false)
                            ->visible(static function (Get $get): bool {
                                return $get('type') === WalletTypeEnum::GENERAL();
                            }),
                    ])->columns(),
            ]);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Tables\Grouping\Group::make('type')
                    ->label(__('wallets.fields.type'))
                    ->collapsible(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('wallets.fields.name'))
                    ->color(static function (?Model $record) {
                        return Color::hex($record?->color);
                    })
                    ->weight('bold')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('wallets.fields.type'))
                    ->badge()
                    ->color(static function (string $state) {
                        return match ($state) {
                            WalletTypeEnum::CREDIT_CARD() => 'danger',
                            WalletTypeEnum::GENERAL() => 'success',
                        };
                    })
                    ->formatStateUsing(static function (string $state): string {
                        return __("wallets.types.{$state}");
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('original_balance')
                    ->label(__('wallets.fields.balance'))
                    ->formatStateUsing(static function (string $state): string {
                        return Number::currency((float) $state, 'EUR', app()->getLocale());
                    })
                    ->weight('bold')
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency_code')
                    ->label(__('wallets.fields.currency_code'))
                    ->formatStateUsing(static function (string $state): string {
                        return Number::currency((float) $state, 'EUR', app()->getLocale());
                    })
                    ->sortable(),

            ])
            ->striped()
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label(__('wallets.fields.type'))
                    ->options(__('wallets.types'))
                    ->multiple()
                    ->searchable(),
            ])
            ->actions([
                Action::make('refresh_balance')
                    ->label(__('wallets.actions.refresh_balance'))
                    ->icon('lucide-refresh-cw')
                    ->color('warning')
                    ->action(function (Wallet $wallet) {
                        $wallet->refreshBalance();

                        Notification::make()
                            ->title($wallet->name)
                            ->body(__('wallets.notifications.balance_refreshed'))
                            ->icon('lucide-refresh-cw')
                            ->color('success')
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
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
            RelationManagers\TransactionsRelationManager::class,
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWallets::route('/'),
            'edit' => Pages\EditWallet::route('/{record}/edit'),
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
