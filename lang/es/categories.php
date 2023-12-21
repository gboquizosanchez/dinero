<?php

use App\Enums\SpendTypeEnum;

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
        SpendTypeEnum::INCOME->value => [
            'id' => SpendTypeEnum::INCOME->value,
            'label' => 'Ingresos',
            'description' => 'Tu categoría de ingresos',
        ],
        SpendTypeEnum::EXPENSE->value => [
            'id' => SpendTypeEnum::EXPENSE->value,
            'label' => 'Gastos',
            'description' => 'Tu categoría de gastos',
        ],
    ],
];
