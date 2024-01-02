<?php

namespace App\Filament\Admin\Resources\Subscriptions\PlanResource\Pages;

use App\Filament\Admin\Resources\Subscriptions\PlanResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePlans extends ManageRecords
{
    protected static string $resource = PlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
