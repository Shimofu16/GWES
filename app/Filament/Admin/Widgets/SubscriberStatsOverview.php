<?php

namespace App\Filament\Admin\Widgets;

use App\Enums\PaymentStatusEnum;
use App\Models\Event;
use App\Models\FeedBack;
use App\Models\Subscriber;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SubscriberStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $active_subscribers = Subscriber::with('companies')
        ->whereHas('companies', function ($query) {
            $query->whereHas('payments', function ($q) {
                $q->where('latest', true)
                    ->where('status',  PaymentStatusEnum::ACTIVE->value);
            });
        })
        ->count();
        $pending_subscribers = Subscriber::with('companies')
        ->whereHas('companies', function ($query) {
            $query->whereHas('payments', function ($q) {
                $q->where('latest', true)
                    ->where('status',  PaymentStatusEnum::PENDING->value);
            });
        })
        ->count();
        $feedbacks = FeedBack::count();
        // $year = now()->year;
        // for ($month = 1; $month <= 12; $month++) {
        //     $subscribers = Subscriber::query();
        //     $subscriberCounts[]  = $subscribers->whereMonth('created_at', $month)
        //         ->whereYear('created_at', $year)
        //         ->count();
        // }

        return [
            Stat::make('Active Subscribers', $active_subscribers)
                ->description('Total Active Subscribers'),
            Stat::make('Pending Subscribers', $pending_subscribers)
                ->description('Total Pending Subscribers'),
            Stat::make('Feedbacks', $feedbacks)
                ->description('Total feedbacks'),
        ];
    }
}
