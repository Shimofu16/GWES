<?php

namespace App\Filament\Admin\Resources\PlanResource\Pages;

use App\Filament\Admin\Resources\PlanResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditPlan extends EditRecord
{
    protected static string $resource = PlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
 // redirect user to index
 protected function getRedirectUrl(): string
 {
     return static::getResource()::getUrl('index');
 }

 // Change the Success Message
 protected function getUpdateNotification(): ?Notification
 {
     return Notification::make()
         ->success()
         ->title('Update Plan')
         ->body('You have successfully updated an plan.');
 }

}
