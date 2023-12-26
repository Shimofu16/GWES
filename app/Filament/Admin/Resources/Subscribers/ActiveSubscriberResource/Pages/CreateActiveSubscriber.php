<?php

namespace App\Filament\Admin\Resources\Subscribers\ActiveSubscriberResource\Pages;

use App\Filament\Admin\Resources\Subscribers\ActiveSubscriberResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateActiveSubscriber extends CreateRecord
{
    protected static string $resource = ActiveSubscriberResource::class;
}
