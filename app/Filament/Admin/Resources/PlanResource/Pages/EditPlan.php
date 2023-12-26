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
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Update Plan')
            ->body('You have successfully updated plan.');
    }
    // Change the Error Message
    protected function getSaveErrorNotification(): ?Notification
    {
        return Notification::make()
            ->danger()
            ->title('Error updating Plan')
            ->body('There was an error updating plan.');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['duration'] = explode(' ', $data['name'])[0];

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['name'] = $data['duration'] . ' ' . (($data['billing_cycle'] == "monthly") ? 'month' : 'year') . ($data['duration'] > 1 ? 's' : '');

        return $data;
    }
}
