<?php

declare(strict_types=1);

use App\Enums\TransactionTypeEnum;

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
        TransactionTypeEnum::DEPOSIT->value => [
            'id' => TransactionTypeEnum::DEPOSIT->value,
            'label' => 'Depósito',
            'description' => 'Depósito a tu cartera',
        ],
        TransactionTypeEnum::WITHDRAW->value => [
            'id' => TransactionTypeEnum::WITHDRAW->value,
            'label' => 'Retirada',
            'description' => 'Retirada de tu cartera',
        ],
        TransactionTypeEnum::TRANSFER->value => [
            'id' => TransactionTypeEnum::TRANSFER->value,
            'label' => 'Transferencia',
            'description' => 'Transferencia entre tus carteras',
        ],
        TransactionTypeEnum::PAYMENT->value => [
            'id' => TransactionTypeEnum::PAYMENT->value,
            'label' => 'Pago',
            'description' => 'Pago de una cartera a otra cartera',
        ],
    ],
];
