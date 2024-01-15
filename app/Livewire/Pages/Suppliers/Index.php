<?php

namespace App\Livewire\Pages\Suppliers;

use App\Enums\PaymentStatusEnum;
use App\Models\Category;
use App\Models\SubscriberCompany;
use Livewire\Component;

class Index extends Component
{
    public $search = '';
    public $query;
    public $categories;
    public $category_types;
    public $category;
    public $category_id;
    public $category_type;

    public function mount(string $query = null, int $id = null)
    {
        $suppliers = SubscriberCompany::query()
            ->with('companyCategories', 'payments')
            ->whereHas('payments', function ($query) {
                $query->where('latest', true)
                    ->where('status', PaymentStatusEnum::ACTIVE->value);
            });
        if ($query === 'category') {
            $suppliers
                ->whereHas('companyCategories', function ($query) use ($id) {
                    $query->where('category_id', $id);
                });
            $this->category_id = $id;
            $this->query = $suppliers->get();
        } elseif ($query === 'supplier') {
            $this->query = $suppliers->where('id', $id);
        }
        $this->query = $suppliers->get();

        // dd($this->query);
        $this->categories = Category::pluck('name', 'id');
    }
    private function search()
    {
        $suppliers = SubscriberCompany::query()->with('companyCategories', 'payments')
            ->whereHas('payments', function ($query) {
                $query->where('latest', true)
                    ->where('status', PaymentStatusEnum::ACTIVE->value);
            });

        if ($this->category_id) {
            $suppliers
                ->whereHas('companyCategories', function ($query) {
                    $query->where('category_id', $this->category_id);
                });
        }
        if ($this->category_type) {
            $suppliers
                ->whereHas('companyCategories', function ($query) {
                    $query->whereHas('category', function ($q) {
                        $q->where('type',  $this->category_type);
                    });
                });
        }

        if ($this->search) {
            $suppliers->where('name', 'like', '%' . $this->search . '%');
        }
        return $suppliers->get();

        // return Category::query()->where('name', 'like', '%' . $this->search . '%')->pluck('name','id');
    }

    public function render()
    {
        return view(
            'livewire.pages.suppliers.index',
            [
                'suppliers' => ($this->search || $this->category_id || $this->category_type) ? $this->search() : $this->query
            ]
        );
    }
}
