<?php

declare(strict_types=1);

namespace Filament\Resources\TransactionResource\Pages;

use Bavix\Wallet\Exceptions\InsufficientFunds;
use Bavix\Wallet\External\Dto\Extra;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\TransactionResource;
use Filament\Support\Exceptions\Halt;
use Override;
use Taka\Domain\Models\Wallet;
use Taka\Support\Enums\TransactionTypeEnum;
use Taka\Support\Enums\WalletTypeEnum;

final class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;

    /**
     * @throws Halt
     */
    #[Override]
    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['amount'] *= 100;

        $type = ($data['type'] ?? null);
        if ($type == TransactionTypeEnum::WITHDRAW()) {
            $data['amount'] *= -1;
            try {
                $this->validateCreditLimit($data);
            } catch (InsufficientFunds $exception) {
                Notification::make()
                    ->danger()
                    ->title('Insufficient funds')
                    ->send();
                $this->halt();
            }
        } elseif (in_array($type, [TransactionTypeEnum::TRANSFER(), TransactionTypeEnum::PAYMENT()])) {
            $this->createTransferOrPaymentTransaction($data);
            $this->halt();
        }

        return $data;
    }

    /**
     * @throws Halt
     */
    public function validateCreditLimit($data): void
    {
        $wallet = Wallet::findOrFail($data['wallet_id']);
        $amount = (float) $wallet->balance + ($data['amount']);

        $amount = $amount / 100; // cents to dollars

        if ($wallet->type == WalletTypeEnum::CREDIT_CARD()) {
            $creditLimit = -1 * (float) array_get($wallet->meta, 'credit');
            if ($amount < $creditLimit) {
                throw new InsufficientFunds('Insufficient funds');
            }
        }
    }

    public function createTransferOrPaymentTransaction($data): void
    {
        $fromWallet = Wallet::findOrFail($data['from_wallet_id']);
        $toWallet = Wallet::findOrFail($data['to_wallet_id']);
        $meta = ['happened_at' => $data['happened_at'] ?? now(), 'type' => $data['type']];

        if (array_get($data, 'type') == TransactionTypeEnum::PAYMENT()) {
            $meta['payment'] = true;
        } elseif (array_get($data, 'type') == TransactionTypeEnum::TRANSFER()) {
            $meta['transfer'] = true;
        }

        $transfer = $fromWallet->transfer($toWallet, $data['amount'], new Extra(
            deposit: $meta,
            withdraw: $meta,
        ));
        $this->record = $transfer->deposit;
    }
}
