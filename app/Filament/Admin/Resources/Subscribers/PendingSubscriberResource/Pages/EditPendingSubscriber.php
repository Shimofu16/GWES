<?php

namespace App\Filament\Admin\Resources\Subscribers\PendingSubscriberResource\Pages;

use App\Filament\Admin\Resources\Subscribers\PendingSubscriberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPendingSubscriber extends EditRecord
{
    protected static string $resource = PendingSubscriberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
