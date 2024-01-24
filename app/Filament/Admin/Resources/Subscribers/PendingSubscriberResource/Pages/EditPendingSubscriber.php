<?php

namespace App\Filament\Admin\Resources\Subscribers\PendingSubscriberResource\Pages;

use App\Filament\Admin\Resources\Subscribers\PendingSubscriberResource;
use App\Models\SubscriberCompanyCategory;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditPendingSubscriber extends EditRecord
{
    protected static string $resource = PendingSubscriberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // dd($data);
        $price_range = explode(' - ', $data['price_range']);
        $data['minimum'] = $price_range[0];
        $data['maximum'] = $price_range[1];
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['price_range'] = $data['minimum'] . ' - ' . $data['maximum'];
        if (!is_array($data['socials'])) {
            $data['socials'] = implode(',', $data['socials']);
        }

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // dd($data, $record->payment->plan->categories);
        $categories = $data['company_categories']; // from form
        if ($categories) {
            // delete current company categories
            $companyCategories = SubscriberCompanyCategory::where('subscriber_company_id', $record->id)->get();
            foreach ($companyCategories as $key => $companyCategory) {
                $companyCategory->delete();
            }
            foreach ($categories as $key => $category) {

                SubscriberCompanyCategory::create([
                    'subscriber_company_id' => $record->id,
                    'category_id' => $category,
                ]);
            }
        }
        $record->update($data);


        return $record;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
