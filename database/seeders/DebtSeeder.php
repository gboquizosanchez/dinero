<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Taka\Domain\Models\Account;
use Taka\Domain\Models\Debt;
use Taka\Domain\Models\Wallet;
use Taka\Support\Enums\DebtTypeEnum;

final class DebtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Debt::create([
            'type' => DebtTypeEnum::PAYABLE(),
            'name' => fake()->name,
            'description' => 'Borrowed money from John Doe for buying a new car',
            'amount' => 800000,
            'start_at' => now()->addYears(2),
            'account_id' => Account::first()->id,
            'wallet_id' => Wallet::first()->id,
            'color' => '#22b3e0',
        ]);

        Debt::create([
            'type' => DebtTypeEnum::RECEIVABLE(),
            'name' => fake()->name,
            'description' => 'Received money from John Doe for buying a new phone',
            'amount' => 100000,
            'start_at' => now()->addYears(2),
            'account_id' => Account::first()->id,
            'wallet_id' => Wallet::first()->id,
            'color' => '#22b3e0',
        ]);
    }
}
