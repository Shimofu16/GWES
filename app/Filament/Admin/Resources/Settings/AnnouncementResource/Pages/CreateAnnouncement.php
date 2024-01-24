<?php

namespace App\Filament\Admin\Resources\Settings\AnnouncementResource\Pages;

use App\Filament\Admin\Resources\Settings\AnnouncementResource;
use App\Models\Announcement;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateAnnouncement extends CreateRecord
{
    protected static string $resource = AnnouncementResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function handleRecordCreation(array $data): Model
    {
        if ($data['is_visible']) {
            $announcement = Announcement::where('is_visible', true)->first();
            if ($announcement) {
                $announcement->update(['is_visible' => false]);
            }
        }

        return static::getModel()::create($data);
    }
}
