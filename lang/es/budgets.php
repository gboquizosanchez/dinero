<?php

use App\Enums\BudgetPeriodEnum;

return [
    'title' => 'Presupuestos',
    'title_singular' => 'Presupuesto',
    'fields' => [
        'name' => 'Nombre',
        'amount' => 'Cantidad',
        'actual_amount' => 'Cantidad real',
        'spend_amount' => 'Cantidad gastada',
        'period' => 'Periodo',
        'day_of_month' => 'Día del mes',
        'day_of_week' => 'Día de la semana',
        'month_of_year' => 'Mes del año',
        'month_of_quarter' => 'Mes del trimestre',
        'status' => 'Estado',
        'color' => 'Color',
        'categories' => 'Categorías',
        'recurrence' => 'Recurrencia',
        'enabled' => '¿Habilitado?',
        'enabled_help_text' => 'Mostrar este presupuesto en el tablero o informe',
    ],
    'periods' => [
        BudgetPeriodEnum::WEEKLY->value => 'Semanal',
        BudgetPeriodEnum::MONTHLY->value => 'Mensual',
        BudgetPeriodEnum::QUARTERLY->value => 'Trimestral',
        BudgetPeriodEnum::YEARLY->value => 'Anual',
    ],
];
