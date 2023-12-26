<?php

namespace App\Filament\Admin\Resources\PlanResource\Pages;

use App\Filament\Admin\Resources\PlanResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

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
            ->body('You have successfully created Plan.');
    }

    protected function handleRecordCreation(array $data): Model
    {
        try {
            $data['name'] = $data['duration'] . ' ' . (($data['billing_cycle'] == "monthly") ? 'month' : 'year') . ($data['duration'] > 1 ? 's' : '');
            return static::getModel()::create($data);
        } catch (\Throwable $th) {
            Notification::make()
                ->success()
                ->title('Error creating Plan')
                ->body($th->getMessage())
                ->send();
            $this->halt();
        }
    }
}
