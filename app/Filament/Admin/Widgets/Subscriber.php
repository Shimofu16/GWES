<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Event;
use App\Models\Subscriber as ModelsSubscriber;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class Subscriber extends ApexChartWidget
{
    protected static ?int $sort = 2;
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'subscriber';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Subscriber';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $year = now()->year;
        $subscriberCounts = [];
        for ($month = 1; $month <= 12; $month++) {
            $subscribers = ModelsSubscriber::query();
            $subscriberCounts[]  = $subscribers->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count();
        }
        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Subscriber',
                    'data' => $subscriberCounts,
                ],
            ],
            'xaxis' => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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
            'stroke' => [
                'curve' => 'smooth',
            ],
        ];
    }
}
