<?php

namespace App\Filament\Admin\Resources\Subscribers\ActiveSubscriberResource\Pages;

use App\Filament\Admin\Resources\Subscribers\ActiveSubscriberResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditActiveSubscriber extends EditRecord
{
    protected static string $resource = ActiveSubscriberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->action(function () {
                    return redirect($this->getResource()::getUrl('index'));
                }),
        ];
    }
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Updated Successfully')
            ->body('Subscriber Updated successfully.');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // dd($data);
        // $price_range = explode(' - ', $data['active_subscribers'][0]['price_range']);
        // $data['minimum'] = $price_range[0];
        // $data['maximum'] = $price_range[1];
        return $data;
    }

        protected function getRedirectUrl(): string
        {
            return $this->getResource()::getUrl('index');
        }
}
