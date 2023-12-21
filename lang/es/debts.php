<?php

use App\Enums\DebtActionTypeEnum;
use App\Enums\DebtTypeEnum;

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
        DebtTypeEnum::PAYABLE->value => 'Pagable',
        DebtTypeEnum::RECEIVABLE->value => 'Cobrable',
    ],
    'action_types' => [
        DebtTypeEnum::RECEIVABLE->value => [
            DebtActionTypeEnum::DEBT_COLLECTION->value => 'Cobro de deuda',
            DebtActionTypeEnum::LOAN_INCREASE->value => 'Aumento de préstamo',
            DebtActionTypeEnum::LOAN_INTEREST->value => 'Interés',
        ],
        DebtTypeEnum::PAYABLE->value => [
            DebtActionTypeEnum::REPAYMENT->value => 'Reembolso',
            DebtActionTypeEnum::DEBT_INCREASE->value => 'Aumento de deuda',
            DebtActionTypeEnum::DEBT_INTEREST->value => 'Interés',
        ],
    ],
];
