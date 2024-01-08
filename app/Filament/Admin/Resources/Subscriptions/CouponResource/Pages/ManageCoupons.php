<?php

namespace App\Filament\Admin\Resources\Subscriptions\CouponResource\Pages;

use App\Filament\Admin\Resources\Subscriptions\CouponResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCoupons extends ManageRecords
{
    protected static string $resource = CouponResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
