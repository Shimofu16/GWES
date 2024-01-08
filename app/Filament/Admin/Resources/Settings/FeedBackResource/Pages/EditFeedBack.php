<?php

namespace App\Filament\Admin\Resources\Settings\FeedBackResource\Pages;

use App\Filament\Admin\Resources\Settings\FeedBackResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFeedBack extends EditRecord
{
    protected static string $resource = FeedBackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
