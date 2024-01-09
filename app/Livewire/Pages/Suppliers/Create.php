<?php

namespace App\Livewire\Pages\Suppliers;

use App\Models\Plan;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $owner_name;
    public $owner_email;
    public $owner_phone;

    public $company_logos = [];
    public $company_names = [];
    public $company_addresses = [];
    public $company_phones = [];
    public $company_price_ranges = [];
    public $company_descriptions = [];
    public $company_socials = [];
    public $company_plans = [];
    public $company_selected_plans = [];

    public $plan_id;
    public $proof_of_payment;

    public $plans;
    public $plan;

    public $company_count;
    public $current_step = 1;
    public $total_step = 3;
    public $allowed_socials;


    public function mount()
    {
        $this->plans = Plan::where('is_visible', true)->get();
    }


    public function save()
    {
        dd($this->company_name);
    }

    private function validateData()
    {
        switch ($this->current_step) {
            case 1:
                $this->validate([
                    'owner_name' => ['required', 'string'],
                    'owner_phone' => ['required', 'string'],
                    'owner_email' => ['required', 'string'],
                    'company_count' => ['required'],
                ]);
                break;
            case 2:
                $this->validate([
                    'company_logos' => ['required'],
                    'company_names' => ['required'],
                    'company_addresses' => ['required'],
                    'company_phones' => ['required'],
                    'company_price_ranges' => ['required'],
                    'company_descriptions' => ['required'],
                    'company_socials' => ['required'],
                    'company_plans' => ['required'],
                ]);
            case 3:
                // dd(
                //     $this->company_logos,
                //     $this->company_names,
                //     $this->company_addresses,
                //     $this->company_phones,
                //     $this->company_price_ranges,
                //     $this->company_descriptions,
                //     $this->company_socials,
                //     $this->company_plans,
                // );
                $this->validate([
                    'owner_name' => ['required', 'string'],
                    'owner_phone' => ['required', 'string'],
                    'owner_email' => ['required', 'string'],
                ]);

                break;

            default:
                # code...
                break;
        }
    }

    public function increaseStep()
    {
        $this->resetErrorBag();
        $this->validateData();
        $this->current_step++;
        if ($this->current_step >= $this->total_step) {
            $this->current_step = $this->total_step;
        }
    }
    public function decreaseStep()
    {
        $this->resetErrorBag();
        $this->current_step--;
        if ($this->current_step < 1) {
            $this->current_step = 1;
        }
    }

    public function addCompany()
    {
        $this->company_count++;
    }
    public function removeCompany($key)
    {
        $this->company_count--;
    }


    public function render()
    {
        return view('livewire.pages.suppliers.create');
    }
}
