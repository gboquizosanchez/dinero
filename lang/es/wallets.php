<?php

use App\Enums\WalletTypeEnum;

return [
    'title' => 'Carteras',
    'title_singular' => 'Cartera',
    'actions' => [
        'refresh_balance' => 'Actualizar balance',
    ],
    'notifications' => [
        'balance_refreshed' => 'Balance actualizado',
    ],
    'fields' => [
        'name' => 'Nombre',
        'type' => 'Tipo',
        'balance' => 'Balance',
        'initial_balance' => 'Balance inicial',
        'credit_limit' => 'Límite de crédito',
        'total_due' => 'Total actualmente adeudado',
        'currency_code' => 'Moneda',
        'description' => 'Descripción',
        'statement_day_of_month' => 'Día del mes de declaración',
        'payment_due_day_of_month' => 'Día del mes de pago vencido',
        'icon' => 'Icono',
        'color' => 'Color',
        'exclude' => [
            'title' => 'Excluir',
            'help_text' => 'Ignora este balance de esta cartera en el balance total',
        ],
    ],
    'types' => [
        WalletTypeEnum::GENERAL->value => 'General',
        WalletTypeEnum::CREDIT_CARD->value => 'Tarjeta de crédito',
    ],
];
