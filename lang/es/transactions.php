<?php

declare(strict_types=1);

use Taka\Support\Enums\TransactionTypeEnum;

return [
    'title' => 'Transacciones',
    'title_singular' => 'Transacción',
    'fields' => [
        'amount' => 'Cantidad',
        'confirmed' => 'Confirmado',
        'category' => 'Categoría',
        'account' => 'Cuenta',
        'happened_at' => 'Ocurrió',
        'description' => 'Descripción',
        'type' => 'Tipo',
        'wallet' => 'Cartera',
        'from_wallet' => 'Desde cartera',
        'to_wallet' => 'A cartera',
        'note' => 'Nota',
        'attachment' => 'Adjunto',
    ],
    'types' => [
        TransactionTypeEnum::DEPOSIT() => [
            'id' => TransactionTypeEnum::DEPOSIT(),
            'label' => 'Depósito',
            'description' => 'Depósito a tu cartera',
        ],
        TransactionTypeEnum::WITHDRAW() => [
            'id' => TransactionTypeEnum::WITHDRAW(),
            'label' => 'Retirada',
            'description' => 'Retirada de tu cartera',
        ],
        TransactionTypeEnum::TRANSFER() => [
            'id' => TransactionTypeEnum::TRANSFER(),
            'label' => 'Transferencia',
            'description' => 'Transferencia entre tus carteras',
        ],
        TransactionTypeEnum::PAYMENT() => [
            'id' => TransactionTypeEnum::PAYMENT(),
            'label' => 'Pago',
            'description' => 'Pago de una cartera a otra cartera',
        ],
    ],
];
