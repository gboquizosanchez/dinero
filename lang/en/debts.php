<?php

declare(strict_types=1);

use Taka\Support\Enums\DebtActionTypeEnum;
use Taka\Support\Enums\DebtTypeEnum;

return [
    'title' => 'Debts',
    'title_singular' => 'Debt',
    'actions' => [
        'debt_transaction' => 'Debt Transaction',
    ],
    'fields' => [
        'name' => 'Name',
        'type' => 'Type',
        'amount' => 'Amount',
        'description' => 'Description',
        'start_at' => 'Start',
        'color' => 'Color',
        'wallet' => 'Wallet',
        'initial_wallet' => 'Initial Wallet',
        'happened_at' => 'Happened',
        'debt' => 'Debt',
        'action_type' => 'Action Type',
        'from_wallet' => 'From Wallet',
        'total_debt_amount' => 'Total Debt Amount',
    ],
    'types' => [
        DebtTypeEnum::PAYABLE() => 'Payable',
        DebtTypeEnum::RECEIVABLE() => 'Receivable',
    ],
    'action_types' => [
        DebtTypeEnum::RECEIVABLE() => [
            DebtActionTypeEnum::DEBT_COLLECTION() => 'Debt Collection',
            DebtActionTypeEnum::LOAN_INCREASE() => 'Loan Increase',
            DebtActionTypeEnum::LOAN_INTEREST() => 'Interest',
        ],
        DebtTypeEnum::PAYABLE() => [
            DebtActionTypeEnum::REPAYMENT() => 'Repayment',
            DebtActionTypeEnum::DEBT_INCREASE() => 'Debt Increase',
            DebtActionTypeEnum::DEBT_INTEREST() => 'Interest',
        ],
    ],
];
