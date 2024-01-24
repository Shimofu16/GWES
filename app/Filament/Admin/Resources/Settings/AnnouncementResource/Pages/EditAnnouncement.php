<?php

namespace App\Filament\Admin\Resources\Settings\AnnouncementResource\Pages;

use App\Filament\Admin\Resources\Settings\AnnouncementResource;
use App\Models\Announcement;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnnouncement extends EditRecord
{
    protected static string $resource = AnnouncementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['is_visible']) {
            $announcement = Announcement::where('is_visible', true)->first();
            $announcement->update(['is_visible' => false]);
        }

        return $data;
    }
}
