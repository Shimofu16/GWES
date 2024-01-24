<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Category;
use App\Models\SubscriberCompany;
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
    protected static ?string $heading = 'Subscribers Per Category';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $labels = [];
        $series = [];
        $categories = Category::pluck('name', 'id');
        $companies = SubscriberCompany::with('subscriber', 'companyCategories')
            ->whereHas('subscriber', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->get();

        foreach ($categories as $key => $category) {
            $labels[] = $category;
            foreach ($companies as $company) {
                $series[] = $company->companyCategories()->where('category_id', $key)->count();
            }
        }
        // dd($labels, $series,$companies,$categories);
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
