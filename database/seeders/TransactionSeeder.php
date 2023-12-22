<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Taka\Domain\Models\Account;
use Taka\Domain\Models\Transaction;
use Taka\Domain\Models\User;
use Taka\Support\Enums\SpendTypeEnum;
use Taka\Support\Enums\TransactionTypeEnum;
use Taka\Support\Enums\WalletTypeEnum;

final class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = Account::all();

        //        Transaction::create([
        //            'wallet_id' => 1,
        //            'payable_type' => User::class,
        //            'payable_id' => 1,
        //            'account_id'  => '01H7BGYYATNB2QY0KBCY60T4VH',
        //            'amount'      => rand(500, 10000),
        //            'type'        => TransactionTypeEnum::DEPOSIT(),
        //            'category_id' => 1,
        //            'confirmed' => true,
        //            'uuid' => fake()->uuid,
        //            'happened_at' => now()->subDays(1),
        //        ]);

        foreach ($accounts as $account) {
            $wallets = $account->wallets;
            $categories = $account->categories;

            foreach ($wallets->where('type', WalletTypeEnum::GENERAL()) as $wallet) {
                $incomeCategories = $categories->where('type',
                    SpendTypeEnum::INCOME());
                $expenseCategories = $categories->where('type',
                    SpendTypeEnum::EXPENSE());

                foreach (range(0, 20) as $i) {
                    Transaction::insert([
                        [
                            'wallet_id' => $wallet->id,
                            'payable_type' => User::class,
                            'payable_id' => 1,
                            'account_id' => $account->id,
                            'amount' => random_int(500, 10000),
                            'type' => TransactionTypeEnum::DEPOSIT(),
                            'category_id' => $incomeCategories->random()->id,
                            'confirmed' => true,
                            'uuid' => fake()->uuid,
                            'happened_at' => now()->subDays($i),
                        ],
                        [
                            'wallet_id' => $wallet->id,
                            'payable_type' => User::class,
                            'payable_id' => 1,
                            'account_id' => $account->id,
                            'amount' => random_int(500, 10000),
                            'type' => TransactionTypeEnum::DEPOSIT(),
                            'category_id' => $incomeCategories->random()->id,
                            'confirmed' => true,
                            'uuid' => fake()->uuid,
                            'happened_at' => now()->subDays($i),
                        ],
                        [
                            'wallet_id' => $wallet->id,
                            'payable_type' => User::class,
                            'payable_id' => 1,
                            'account_id' => $account->id,
                            'amount' => -1 * random_int(500, 1000),
                            'type' => TransactionTypeEnum::WITHDRAW(),
                            'category_id' => $expenseCategories->random()->id,
                            'confirmed' => true,
                            'uuid' => fake()->uuid,
                            'happened_at' => now()->subDays($i),
                        ],
                        [
                            'wallet_id' => $wallet->id,
                            'payable_type' => User::class,
                            'payable_id' => 1,
                            'account_id' => $account->id,
                            'amount' => -1 * random_int(500, 1000),
                            'type' => TransactionTypeEnum::WITHDRAW(),
                            'category_id' => $expenseCategories->random()->id,
                            'confirmed' => true,
                            'uuid' => fake()->uuid,
                            'happened_at' => now()->subDays($i),
                        ],
                        [
                            'wallet_id' => $wallet->id,
                            'payable_type' => User::class,
                            'payable_id' => 1,
                            'account_id' => $account->id,
                            'amount' => -1 * random_int(500, 1000),
                            'type' => TransactionTypeEnum::WITHDRAW(),
                            'category_id' => $expenseCategories->random()->id,
                            'confirmed' => true,
                            'uuid' => fake()->uuid,
                            'happened_at' => now()->subDays($i),
                        ],
                    ]);
                }
                $wallet->refreshBalance();
            }
        }
    }
}
