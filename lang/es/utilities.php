<?php

declare(strict_types=1);

use Taka\Support\Enums\MonthEnum;
use Taka\Support\Enums\QuarterEnum;
use Taka\Support\Enums\VisibilityStatusEnum;
use Taka\Support\Enums\WeekdayEnum;

return [
    'visibility_statuses' => [
        VisibilityStatusEnum::ACTIVE->value => 'Activo',
        VisibilityStatusEnum::INACTIVE->value => 'Inactivo',
    ],
    'weekdays' => [
        WeekdayEnum::SUNDAY->value => 'Domingo',
        WeekdayEnum::MONDAY->value => 'Lunes',
        WeekdayEnum::TUESDAY->value => 'Martes',
        WeekdayEnum::WEDNESDAY->value => 'Miércoles',
        WeekdayEnum::THURSDAY->value => 'Jueves',
        WeekdayEnum::FRIDAY->value => 'Viernes',
        WeekdayEnum::SATURDAY->value => 'Sábado',
    ],
    'months' => [
        MonthEnum::JANUARY->value => 'Enero',
        MonthEnum::FEBRUARY->value => 'Febrero',
        MonthEnum::MARCH->value => 'Marzo',
        MonthEnum::APRIL->value => 'Abril',
        MonthEnum::MAY->value => 'Mayo',
        MonthEnum::JUNE->value => 'Junio',
        MonthEnum::JULY->value => 'Julio',
        MonthEnum::AUGUST->value => 'Agosto',
        MonthEnum::SEPTEMBER->value => 'Septiembre',
        MonthEnum::OCTOBER->value => 'Octubre',
        MonthEnum::NOVEMBER->value => 'Noviembre',
        MonthEnum::DECEMBER->value => 'Diciembre',
    ],
    'quarter_months' => [
        QuarterEnum::FIRST_MONTH->value => 'Primer mes',
        QuarterEnum::SECOND_MONTH->value => 'Segundo mes',
        QuarterEnum::THIRD_MONTH->value => 'Tercer mes',
    ],
];
