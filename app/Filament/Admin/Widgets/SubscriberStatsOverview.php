<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Event;
use App\Models\Subscriber;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SubscriberStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $year = now()->year;
        $subscriberCounts = [];
        $eventCounts = [];
        for ($month = 1; $month <= 12; $month++) {
            $events = Event::query();
            $subscribers = Subscriber::query();
            $subscriberCounts[]  = $subscribers->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count();
            $eventCounts[] = $events->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count();
        }

        return [
            Stat::make('Subscribers', $subscribers->count())
                ->chart($subscriberCounts)
                ->color('success'),
            Stat::make('Events', $events->count())
                ->chart($eventCounts)
                ->color('success'),
        ];
    }
}
