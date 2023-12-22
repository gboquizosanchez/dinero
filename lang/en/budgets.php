<?php

declare(strict_types=1);

use Taka\Support\Enums\BudgetPeriodEnum;

return [
    'title' => 'Budgets',
    'title_singular' => 'Budget',
    'fields' => [
        'name' => 'Name',
        'amount' => 'Amount',
        'actual_amount' => 'Actual Amount',
        'spend_amount' => 'Spend Amount',
        'period' => 'Period',
        'day_of_month' => 'Day of Month',
        'day_of_week' => 'Day of Week',
        'month_of_year' => 'Month of Year',
        'month_of_quarter' => 'Month of Quarter',
        'status' => 'Status',
        'color' => 'Color',
        'categories' => 'Categories',
        'recurrence' => 'Recurrence',
        'enabled' => 'Enabled ?',
        'enabled_help_text' => 'Show this budget on the dashboard or report',
    ],
    'periods' => [
        BudgetPeriodEnum::WEEKLY() => 'Weekly',
        BudgetPeriodEnum::MONTHLY() => 'Monthly',
        BudgetPeriodEnum::QUARTERLY() => 'Quarterly',
        BudgetPeriodEnum::YEARLY() => 'Yearly',
    ],
];
