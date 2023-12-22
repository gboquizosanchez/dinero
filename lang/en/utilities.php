<?php

declare(strict_types=1);

use Taka\Support\Enums\MonthEnum;
use Taka\Support\Enums\QuarterEnum;
use Taka\Support\Enums\VisibilityStatusEnum;
use Taka\Support\Enums\WeekdayEnum;

return [
    'visibility_statuses' => [
        VisibilityStatusEnum::ACTIVE() => 'Active',
        VisibilityStatusEnum::INACTIVE() => 'Inactive',
    ],
    'weekdays' => [
        WeekdayEnum::SUNDAY() => 'Sunday',
        WeekdayEnum::MONDAY() => 'Monday',
        WeekdayEnum::TUESDAY() => 'Tuesday',
        WeekdayEnum::WEDNESDAY() => 'Wednesday',
        WeekdayEnum::THURSDAY() => 'Thursday',
        WeekdayEnum::FRIDAY() => 'Friday',
        WeekdayEnum::SATURDAY() => 'Saturday',
    ],
    'months' => [
        MonthEnum::JANUARY() => 'January',
        MonthEnum::FEBRUARY() => 'February',
        MonthEnum::MARCH() => 'March',
        MonthEnum::APRIL() => 'April',
        MonthEnum::MAY() => 'May',
        MonthEnum::JUNE() => 'June',
        MonthEnum::JULY() => 'July',
        MonthEnum::AUGUST() => 'August',
        MonthEnum::SEPTEMBER() => 'September',
        MonthEnum::OCTOBER() => 'October',
        MonthEnum::NOVEMBER() => 'November',
        MonthEnum::DECEMBER() => 'December',
    ],
    'quarter_months' => [
        QuarterEnum::FIRST_MONTH() => 'First Month',
        QuarterEnum::SECOND_MONTH() => 'Second Month',
        QuarterEnum::THIRD_MONTH() => 'Third Month',
    ],
];
