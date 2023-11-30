<?php

namespace App\Filament\Admin\Resources\CategoryResource\Pages;

use App\Filament\Admin\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    // redirect user to index
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    // Change the Success Message
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Create Category')
            ->body('You have successfully created an category.');
    }

    // Notification::make()
    //   ->title('')
    //     ->body('')
    //     ->success()
    //     ->icon('')
    //     ->iconColor('')
    //     ->duration(5000)
    //     ->persistent()
    //     ->actions([

    //     ])
    //     ->send();
}
