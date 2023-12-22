<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AccountSeeder::class,
            WalletSeeder::class,
            CategorySeeder::class,
            TransactionSeeder::class,
            GoalSeeder::class,
            DebtSeeder::class,
        ]);
    }
}
