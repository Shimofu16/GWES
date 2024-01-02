<?php

namespace App\Filament\Admin\Resources\Subscribers\ActiveSubscriberResource\Pages;

use App\Filament\Admin\Resources\Subscribers\ActiveSubscriberResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListActiveSubscribers extends ListRecords
{
    protected static string $resource = ActiveSubscriberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getBreadcrumbs(): array
    {
        return [
            'Active',
            'Subscriber',
            'List',
        ];
    }

    public function getTitle(): string
    {
        return 'Subscribers';
    }
}
