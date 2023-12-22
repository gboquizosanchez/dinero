<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Taka\Domain\Models\Account;
use Taka\Domain\Models\User;
use Taka\Support\Enums\WalletTypeEnum;

final class WalletSeeder extends Seeder
{
    public function run(): void
    {
        $wallets = [
            [
                'name' => 'Cash',
                'type' => WalletTypeEnum::GENERAL(),
                'currency_code' => 'EUR',
                'color' => '#22b3e0',
            ],
            [
                'name' => 'Bank',
                'type' => WalletTypeEnum::GENERAL(),
                'currency_code' => 'EUR',
                'color' => '#224ce0',
            ],
            [
                'name' => 'Mobile Wallet',
                'type' => WalletTypeEnum::GENERAL(),
                'currency_code' => 'EUR',
                'color' => '#e07222',
            ],
            [
                'name' => 'Credit Card',
                'type' => WalletTypeEnum::CREDIT_CARD(),
                'currency_code' => 'EUR',
                'color' => '#22a1e0',
            ],
        ];

        $accounts = Account::all();
        $user = User::first();

        foreach ($accounts as $key => $account) {
            foreach ($wallets as $wallet) {
                if ($key !== 0 && $wallet['type'] === WalletTypeEnum::CREDIT_CARD()) {
                    continue;
                }

                $wallet['account_id'] = $account->id;
                $wallet['slug'] = strtolower($wallet['name']) . ($key !== 0 ? '-' . ($key + 1) : '');
                $user->createWallet($wallet);
            }
        }
    }
}
