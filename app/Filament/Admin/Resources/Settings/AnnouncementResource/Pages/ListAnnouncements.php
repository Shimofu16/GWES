<?php

namespace App\Filament\Admin\Resources\Settings\AnnouncementResource\Pages;

use App\Filament\Admin\Resources\Settings\AnnouncementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnnouncements extends ListRecords
{
    protected static string $resource = AnnouncementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
