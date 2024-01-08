<?php

namespace App\Filament\Admin\Resources\Subscribers\PendingSubscriberResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use App\Enums\PaymentStatusEnum;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Admin\Resources\Subscribers\PendingSubscriberResource;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ListPendingSubscribers extends ListRecords
{
    protected static string $resource = PendingSubscriberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make('New Subscriber'),
        ];
    }

    public function getBreadcrumbs(): array
    {
        return [
            'Pending',
            'Subscriber',
            'List',
        ];
    }

    public function getTitle(): string
    {
        return 'Subscribers';
    }

    public function getTabs(): array
    {
        // $tabs = ['all' => Tab::make('All')->badge($this->getModel()::count())];

        foreach (PaymentStatusEnum::toArray() as $status) {
            if ($status != 'active') {

                $name = Str::ucfirst($status);
                $subscriber_count = $this->getModel()::query()->with('payments')
                    ->whereHas('payments', function ($q) use ($status) {
                        $q->where('latest', true)
                            ->where('status',  $status);
                    })
                    ->count();
                $tabs[$status] = Tab::make($name)
                    ->badge($subscriber_count)
                    ->icon(PaymentStatusEnum::getIcon($status))
                    ->modifyQueryUsing(function ($query) use ($status) {
                        $query
                            ->with('payments')
                            ->whereHas('payments', function ($q) use ($status) {
                                $q->where('latest', true)
                                    ->where('status',  $status);
                            });
                    });
            }
        }

        return $tabs;
    }
}
