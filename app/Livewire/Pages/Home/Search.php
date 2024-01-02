<?php

namespace App\Livewire\Pages\Home;

use App\Models\Category;
use App\Models\SubscriberCompany;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Url(as: 'q')]
class Search extends Component
{
    public $search = '';
    public $classes = '';



    public function resetSearch(){
        $this->reset('search');
    }

    public function search()
    {
        return Category::query()->where('name', 'like', '%' . $this->search . '%')->pluck('name','id');
    }

    public function render()
    {
        return view('livewire.pages.home.search', [
            'suppliers' =>   $this->search() 
        ]);
        /* return view('livewire.pages.home.search', [
            'suppliers' => $this->search ? SubscriberCompany::search($this->search)->pluck('name') : SubscriberCompany::pluck('name')
        ]); */
    }
}
