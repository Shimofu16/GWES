<?php

namespace App\Filament\Admin\Resources\Subscribers\PendingSubscriberResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use App\Enums\SubscriberStatusEnum;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Admin\Resources\Subscribers\PendingSubscriberResource;
use Filament\Resources\Pages\ListRecords\Tab;

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

        foreach (SubscriberStatusEnum::toArray() as $status) {
            if ($status != 'active') {

                $name = Str::ucfirst($status);
                $subscriber_count = $this->getModel()::query()->where('status', $status)->count();
                $tabs[$status] = Tab::make($name)
                    ->badge($subscriber_count)
                    ->icon(SubscriberStatusEnum::getIcon($status))
                    ->modifyQueryUsing(function ($query) use ($status) {
                        return $query->where('status', $status);
                    });
            }
        }

        return $tabs;
    }
}
