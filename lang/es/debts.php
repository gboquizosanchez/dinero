<?php

declare(strict_types=1);

use Taka\Support\Enums\DebtActionTypeEnum;
use Taka\Support\Enums\DebtTypeEnum;

return [
    'title' => 'Deudas',
    'title_singular' => 'Deuda',
    'actions' => [
        'debt_transaction' => 'Transacción de deuda',
    ],
    'fields' => [
        'name' => 'Nombre',
        'type' => 'Tipo',
        'amount' => 'Cantidad',
        'description' => 'Descripción',
        'start_at' => 'Inicio',
        'color' => 'Color',
        'wallet' => 'Cartera',
        'initial_wallet' => 'Cartera inicial',
        'happened_at' => 'Ocurrió',
        'debt' => 'Deuda',
        'action_type' => 'Tipo de acción',
        'from_wallet' => 'Desde cartera',
        'total_debt_amount' => 'Cantidad total de deuda',
    ],
    'types' => [
        DebtTypeEnum::PAYABLE() => 'Pagable',
        DebtTypeEnum::RECEIVABLE() => 'Cobrable',
    ],
    'action_types' => [
        DebtTypeEnum::RECEIVABLE() => [
            DebtActionTypeEnum::DEBT_COLLECTION() => 'Cobro de deuda',
            DebtActionTypeEnum::LOAN_INCREASE() => 'Aumento de préstamo',
            DebtActionTypeEnum::LOAN_INTEREST() => 'Interés',
        ],
        DebtTypeEnum::PAYABLE() => [
            DebtActionTypeEnum::REPAYMENT() => 'Reembolso',
            DebtActionTypeEnum::DEBT_INCREASE() => 'Aumento de deuda',
            DebtActionTypeEnum::DEBT_INTEREST() => 'Interés',
        ],
    ],
];
