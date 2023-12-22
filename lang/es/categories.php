<?php

declare(strict_types=1);

use Taka\Support\Enums\SpendTypeEnum;

return [
    'title' => 'Categorías',
    'title_singular' => 'Categoría',
    'fields' => [
        'name' => 'Nombre',
        'type' => 'Tipo',
        'icon' => 'Icono',
        'color' => 'Color',
        'monthly_balance' => 'Balance mensual',
        'total' => 'Total',
        'is_visible' => '¿Es visible?',
        'is_visible_help_text' => 'Ignora esta categoría en el balance total y no la muestres en la lista de transacciones',
    ],
    'types' => [
        SpendTypeEnum::INCOME() => [
            'id' => SpendTypeEnum::INCOME(),
            'label' => 'Ingresos',
            'description' => 'Tu categoría de ingresos',
        ],
        SpendTypeEnum::EXPENSE() => [
            'id' => SpendTypeEnum::EXPENSE(),
            'label' => 'Gastos',
            'description' => 'Tu categoría de gastos',
        ],
    ],
];