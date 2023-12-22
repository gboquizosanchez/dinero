<?php

declare(strict_types=1);

namespace Filament\Resources\DebtResource\Pages;

use Bavix\Wallet\Internal\Service\UuidFactoryServiceInterface;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Components\Tab;
use Filament\Resources\DebtResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Override;
use Taka\Domain\Models\Debt;
use Taka\Domain\Models\User;
use Taka\Domain\Models\Wallet;
use Taka\Support\Enums\DebtActionTypeEnum;
use Taka\Support\Enums\DebtTypeEnum;
use Taka\Support\Enums\TransactionTypeEnum;

final class ListDebts extends ListRecords
{
    protected static string $resource = DebtResource::class;

    #[Override]
    public function getHeaderActions(): array
    {
        return [
            Action::make('deposit')
                ->label(__('debts.actions.debt_transaction'))
                ->color('danger')
                ->icon('lucide-trending-up')
                ->form($this->getDebtTransactionFields())
                ->action(function (array $data) {
                    $this->makeDebtTransaction($data);
                }),
            Actions\CreateAction::make(),
        ];
    }

    #[Override]
    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->icon('helping-hand')
                ->badge(Debt::tenant()->count()),
            DebtTypeEnum::PAYABLE() => Tab::make()
                ->icon('lucide-trending-down')
                ->badge(Debt::tenant()->where('type', DebtTypeEnum::PAYABLE())->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', DebtTypeEnum::PAYABLE())),
            DebtTypeEnum::RECEIVABLE() => Tab::make()
                ->icon('lucide-trending-up')
                ->badge(Debt::tenant()->where('type', DebtTypeEnum::RECEIVABLE())->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', DebtTypeEnum::RECEIVABLE())),
        ];
    }

    public function getDebtTransactionFields($debtId = null): array
    {
        return [
            Hidden::make('debt_id')
                ->default($debtId)
                ->visible(fn () => $debtId !== null),
            Select::make('debt_id')
                ->label(__('debts.fields.debt'))
                ->options(Debt::tenant()->pluck('name', 'id')->toArray())
                ->visible(fn () => $debtId === null)
                ->searchable()
                ->live()
                ->required(),
            Select::make('action_type')
                ->label(__('debts.fields.action_type'))
                ->options(function (Get $get) {
                    if (blank($get('debt_id'))) {
                        return [];
                    }

                    $debt = Debt::findOrFail($get('debt_id'));

                    return __('debts.action_types.' . $debt->type);
                })
                ->searchable(fn (Get $get) => ! blank($get('debt_id')))
                ->live()
                ->required(),
            Select::make('wallet_id')
                ->label(__('debts.fields.wallet'))
                ->options(Wallet::tenant()->pluck('name', 'id')->toArray())
                ->searchable()
                ->required()
                ->visible(fn (Get $get) => ! in_array($get('action_type'), [DebtActionTypeEnum::LOAN_INTEREST(), DebtActionTypeEnum::DEBT_INTEREST()])),
            DateTimePicker::make('happened_at')
                ->label(__('debts.fields.happened_at'))
                ->default(now()),
            TextInput::make('amount')
                ->label(__('debts.fields.amount'))
                ->numeric()
                ->required(),
        ];
    }

    public function makeDebtTransaction($data): void
    {
        try {
            $amount = (float) $data['amount'];
            $actionType = $data['action_type'];
            $happenedAt = $data['happened_at'];
            $method = match ($actionType) {
                DebtActionTypeEnum::REPAYMENT(), DebtActionTypeEnum::LOAN_INCREASE() => 'withdraw',
                DebtActionTypeEnum::DEBT_INCREASE(), DebtActionTypeEnum::DEBT_COLLECTION() => 'deposit',
                default => null,
            };

            if (in_array($actionType, [DebtActionTypeEnum::DEBT_INTEREST(), DebtActionTypeEnum::LOAN_INTEREST()])) {
                $debt = Debt::findOrFail($data['debt_id']);
                $this->makeInterestTransaction(debt: $debt, amount: $amount, actionType: $actionType, happenedAt: $happenedAt);
            }

            if (! blank($method)) {
                $wallet = Wallet::findOrFail($data['wallet_id']);
                $wallet->{$method}($amount * 100, [
                    'happened_at' => $happenedAt,
                    'reference_type' => Debt::class,
                    'reference_id' => $data['debt_id'],
                ]);
            }

            Notification::make()
                ->title('Saved successfully')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function makeInterestTransaction(Debt $debt, $amount, $actionType, $happenedAt = null): void
    {
        $type = match ($debt->type) {
            DebtTypeEnum::PAYABLE() => TransactionTypeEnum::DEPOSIT(),
            DebtTypeEnum::RECEIVABLE() => TransactionTypeEnum::WITHDRAW(),
            default => null,
        };
        $debt->transactions()->create([
            'type' => $type,
            'account_id' => $debt->account_id,
            'payable_type' => User::class,
            'uuid' => app(UuidFactoryServiceInterface::class)->uuid4(),
            'payable_id' => optional(auth()->user())->id,
            'amount' => match ($debt->type) {
                DebtTypeEnum::PAYABLE() => $amount,
                DebtTypeEnum::RECEIVABLE() => $amount * -1,
                default => 0,
            },
            'happened_at' => $happenedAt ?? now(),
            'confirmed' => true,
            'meta' => [
                'action_type' => $actionType,
            ],
        ]);
    }
}
