<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Taka\Domain\Models\Account;
use Taka\Domain\Models\Category;
use Taka\Support\Enums\SpendTypeEnum;

final class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Bills',
                'type' => SpendTypeEnum::EXPENSE(),
                'color' => '#22b3e0',
                'icon' => 'receipt',
            ],
            [
                'name' => 'Food',
                'type' => SpendTypeEnum::EXPENSE(),
                'color' => '#224ce0',
                'icon' => 'lucide-utensils',
            ],
            [
                'name' => 'Transport',
                'type' => SpendTypeEnum::EXPENSE(),
                'color' => '#e07222',
                'icon' => 'lucide-bus',
            ],
            [
                'name' => 'Shopping',
                'type' => SpendTypeEnum::EXPENSE(),
                'color' => '#22a1e0',
                'icon' => 'lucide-shirt',
            ],
            [
                'name' => 'Entertainment',
                'type' => SpendTypeEnum::EXPENSE(),
                'color' => '#e02222',
                'icon' => 'lucide-gamepad-2',
            ],
            [
                'name' => 'Health',
                'type' => SpendTypeEnum::EXPENSE(),
                'color' => '#22e0b3',
                'icon' => 'lucide-stethoscope',
            ],
            [
                'name' => 'Education',
                'type' => SpendTypeEnum::EXPENSE(),
                'color' => '#e0b322',
                'icon' => 'lucide-graduation-cap',
            ],
            [
                'name' => 'Gifts',
                'type' => SpendTypeEnum::EXPENSE(),
                'color' => '#22e0b3',
                'icon' => 'lucide-gift',
            ],
            [
                'name' => 'Salary',
                'type' => SpendTypeEnum::INCOME(),
                'color' => '#e0b322',
                'icon' => 'lucide-banknote',
            ],
            [
                'name' => 'Business',
                'type' => SpendTypeEnum::INCOME(),
                'color' => '#2279e0',
                'icon' => 'lucide-building-2',
            ],
            [
                'name' => 'Extra Income',
                'type' => SpendTypeEnum::INCOME(),
                'color' => '#e0b322',
                'icon' => 'lucide-coins',
            ],
        ];

        $accounts = Account::all();

        foreach ($accounts as $account) {
            foreach ($categories as $category) {
                $category['account_id'] = $account->id;

                Category::create($category);
            }
        }
    }
}
