<?php

declare(strict_types=1);

use Taka\Support\Enums\TransactionTypeEnum;

return [
    'title' => 'Transactions',
    'title_singular' => 'Transaction',
    'fields' => [
        'amount' => 'Amount',
        'confirmed' => 'Confirmed',
        'category' => 'Category',
        'account' => 'Account',
        'happened_at' => 'Happened',
        'description' => 'Description',
        'type' => 'Type',
        'wallet' => 'Wallet',
        'from_wallet' => 'From Wallet',
        'to_wallet' => 'To Wallet',
        'note' => 'Note',
        'attachment' => 'Attachment',
    ],
    'types' => [
        TransactionTypeEnum::DEPOSIT() => [
            'id' => TransactionTypeEnum::DEPOSIT(),
            'label' => 'Deposit',
            'description' => 'Deposit to your wallet',
        ],
        TransactionTypeEnum::WITHDRAW() => [
            'id' => TransactionTypeEnum::WITHDRAW(),
            'label' => 'Withdraw',
            'description' => 'Withdraw from your wallet',
        ],
        TransactionTypeEnum::TRANSFER() => [
            'id' => TransactionTypeEnum::TRANSFER(),
            'label' => 'Transfer',
            'description' => 'Transfer between your wallets',
        ],
        TransactionTypeEnum::PAYMENT() => [
            'id' => TransactionTypeEnum::PAYMENT(),
            'label' => 'Payment',
            'description' => 'Payment to one wallet to another wallet',
        ],
    ],
];
