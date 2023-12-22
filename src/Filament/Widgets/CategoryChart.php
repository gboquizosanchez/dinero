<?php

declare(strict_types=1);

namespace Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Override;
use Taka\Domain\Models\Category;
use Taka\Domain\Models\Transaction;
use Taka\Support\Enums\TransactionTypeEnum;

final class CategoryChart extends ApexChartWidget
{
    protected static string $chartId = 'categoryChart';

    protected static ?int $sort = 2;

    protected static ?string $heading = 'Top Category Transactions';

    protected static ?int $contentHeight = 300;

    #[Override]
    public function getOptions(): array
    {
        $transactions = Transaction::with('category')
            ->whereNotNull('category_id')
            ->tenant()
            ->where('type', TransactionTypeEnum::WITHDRAW())
            ->whereBetween('happened_at', [now()->subDays(10)->startOfDay(), now()->endOfDay()])
            ->get()
            ->groupBy(function ($item) {
                return $item->category_id;
            })
            ->map(function ($item) {
                return $item->sum('amount') * -1;
            })->sortDesc()->take(10);

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'BasicBarChart',
                    'data' => $transactions->values()->toArray(),
                ],
            ],
            'xaxis' => [
                'categories' => Category::whereIn('id', $transactions->keys())->pluck('name')->toArray(),
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b'],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 3,
                    'horizontal' => true,
                ],
            ],
        ];
    }
}
