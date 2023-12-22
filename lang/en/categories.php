<?php

declare(strict_types=1);

use Taka\Support\Enums\SpendTypeEnum;

return [
    'title' => 'Categories',
    'title_singular' => 'Category',
    'fields' => [
        'name' => 'Name',
        'type' => 'Type',
        'icon' => 'Icon',
        'color' => 'Color',
        'monthly_balance' => 'Monthly Balance',
        'total' => 'Total',
        'is_visible' => 'Is Visible?',
        'is_visible_help_text' => 'Ignore this category on the total balance and not showing on the transaction list',
    ],
    'types' => [
        SpendTypeEnum::INCOME() => [
            'id' => SpendTypeEnum::INCOME(),
            'label' => 'Income',
            'description' => 'your income category',
        ],
        SpendTypeEnum::EXPENSE() => [
            'id' => SpendTypeEnum::EXPENSE(),
            'label' => 'Expense',
            'description' => 'your expense category',
        ],
    ],
];
