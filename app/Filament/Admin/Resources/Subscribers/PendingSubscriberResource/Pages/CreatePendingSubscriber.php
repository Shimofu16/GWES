<?php

namespace App\Filament\Admin\Resources\Subscribers\PendingSubscriberResource\Pages;

use App\Filament\Admin\Resources\Subscribers\PendingSubscriberResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePendingSubscriber extends CreateRecord
{
    protected static string $resource = PendingSubscriberResource::class;
}
