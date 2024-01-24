<?php

namespace App\Livewire\Pages\Home;

use App\Enums\PaymentStatusEnum;
use App\Models\Category;
use App\Models\SubscriberCompany;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Url(as: 'q')]
class Search extends Component
{
    public $search = '';
    public $classes = '';



    public function resetSearch()
    {
        $this->reset('search');
    }

    public function search()
    {
        return SubscriberCompany::query()
            ->with('payments', 'companyCategories')
            ->whereHas('payments', function ($query) {
                $query->where('latest', true)
                    ->where('status', PaymentStatusEnum::ACTIVE->value);
            })
            ->whereHas('subscriber', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->where('name', 'like', '%' . $this->search . '%')
            ->pluck('name', 'id');
    }

    public function placeholder(array $params = [])
    {
        return view('livewire.placeholders.skeleton', $params);
    }

    public function render()
    {
        return view(
            'livewire.pages.home.search',
            [
                'suppliers' =>   $this->search()
            ]
        );
    }
}
