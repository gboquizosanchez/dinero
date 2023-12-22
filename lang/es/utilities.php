<?php

declare(strict_types=1);

use Taka\Support\Enums\MonthEnum;
use Taka\Support\Enums\QuarterEnum;
use Taka\Support\Enums\VisibilityStatusEnum;
use Taka\Support\Enums\WeekdayEnum;

return [
    'visibility_statuses' => [
        VisibilityStatusEnum::ACTIVE() => 'Activo',
        VisibilityStatusEnum::INACTIVE() => 'Inactivo',
    ],
    'weekdays' => [
        WeekdayEnum::SUNDAY() => 'Domingo',
        WeekdayEnum::MONDAY() => 'Lunes',
        WeekdayEnum::TUESDAY() => 'Martes',
        WeekdayEnum::WEDNESDAY() => 'Miércoles',
        WeekdayEnum::THURSDAY() => 'Jueves',
        WeekdayEnum::FRIDAY() => 'Viernes',
        WeekdayEnum::SATURDAY() => 'Sábado',
    ],
    'months' => [
        MonthEnum::JANUARY() => 'Enero',
        MonthEnum::FEBRUARY() => 'Febrero',
        MonthEnum::MARCH() => 'Marzo',
        MonthEnum::APRIL() => 'Abril',
        MonthEnum::MAY() => 'Mayo',
        MonthEnum::JUNE() => 'Junio',
        MonthEnum::JULY() => 'Julio',
        MonthEnum::AUGUST() => 'Agosto',
        MonthEnum::SEPTEMBER() => 'Septiembre',
        MonthEnum::OCTOBER() => 'Octubre',
        MonthEnum::NOVEMBER() => 'Noviembre',
        MonthEnum::DECEMBER() => 'Diciembre',
    ],
    'quarter_months' => [
        QuarterEnum::FIRST_MONTH() => 'Primer mes',
        QuarterEnum::SECOND_MONTH() => 'Segundo mes',
        QuarterEnum::THIRD_MONTH() => 'Tercer mes',
    ],
];
