<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Category;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class SubscriberPerCategory extends ApexChartWidget
{
    protected static ?int $sort = 2;
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'subscriberPerCategory';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'SubscriberPerCategory';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $series = [];
        $labels = [];
        $categories = Category::all();
        foreach ($categories as $category) {
            $labels[] = $category->name;
            $series[] = $category->subscribersCount();
        }
        return [
            'chart' => [
                'type' => 'pie',
                'height' => 300,
            ],
            'series' => $series,
            'labels' => $labels,
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
        ];
    }
}
