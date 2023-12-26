<?php

namespace App\Filament\Admin\Resources\Subscribers\ActiveSubscriberResource\Pages;

use App\Filament\Admin\Resources\Subscribers\ActiveSubscriberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditActiveSubscriber extends EditRecord
{
    protected static string $resource = ActiveSubscriberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
