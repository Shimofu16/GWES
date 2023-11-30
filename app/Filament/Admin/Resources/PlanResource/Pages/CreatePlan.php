<?php

namespace App\Filament\Admin\Resources\PlanResource\Pages;

use App\Filament\Admin\Resources\PlanResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePlan extends CreateRecord
{
    protected static string $resource = PlanResource::class;

     // redirect user to index
     protected function getRedirectUrl(): string
     {
         return static::getResource()::getUrl('index');
     }

     protected function getCreatedNotification(): ?Notification
     {
         return Notification::make()
             ->success()
             ->title('Created a Plan')
             ->body('You have successfully created an Plan.');
     }

}
