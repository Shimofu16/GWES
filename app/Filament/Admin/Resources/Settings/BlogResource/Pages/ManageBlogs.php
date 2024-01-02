<?php

namespace App\Filament\Admin\Resources\Settings\BlogResource\Pages;

use App\Filament\Admin\Resources\Settings\BlogResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBlogs extends ManageRecords
{
    protected static string $resource = BlogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
