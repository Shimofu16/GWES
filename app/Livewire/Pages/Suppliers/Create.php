<?php

namespace App\Livewire\Pages\Suppliers;

use App\Enums\DiscountTypeEnum;
use App\Enums\PlanTypeEnum;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Subscriber;
use App\Models\SubscriberCompany;
use App\Models\SubscriberCompanyCategory;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;

class Create extends Component
{
    use WithFileUploads;

    public $owner_name;
    public $owner_email;
    public $owner_phone;


    public $companies = [];

    public $proof_of_payment;
    public $coupon;
    public $redeemed_coupon;


    public $plans;
    public $selected_plan_sum = 0;
    public $plan_sum = 0;
    public $categories;
    public $selected_plans = [];
    public $selected_plans_array = [];

    public $company_count;
    public $current_step = 1;
    public $total_step = 3;


    public function mount()
    {
        $this->plans = Plan::where('is_visible', true)->get();
        $this->categories = Category::pluck('name', 'id');
    }



    private function validateData()
    {
        switch ($this->current_step) {
            case 1:
                $this->validate([
                    'owner_name' => ['required', 'string'],
                    'owner_phone' => ['required', 'string'],
                    'owner_email' => ['required', 'string', 'unique:subscribers,email'],
                    'company_count' => 'required',
                ]);
                break;
            case 2:
                $this->validate([
                    'companies.0.logo' => 'required',
                    'companies.0.image' => 'required',
                    'companies.0.name' => 'required',
                    'companies.0.address' => 'required',
                    'companies.0.phone' => 'required',
                    'companies.0.from' => 'required',
                    'companies.0.to' => 'required',
                    'companies.0.description' => 'required',
                    'companies.0.socials' => 'required',
                    'companies.0.plan' => 'required',
                    'companies.0.categories.*' => 'required',
                    'companies.*.logo' => 'required',
                    'companies.*.image' => 'required',
                    'companies.*.name' => 'required',
                    'companies.*.address' => 'required',
                    'companies.*.phone' => 'required',
                    'companies.*.from' => 'required',
                    'companies.*.to' => 'required',
                    'companies.*.description' => 'required',
                    'companies.*.socials' => 'required',
                    'companies.*.plan' => 'required',
                    'companies.*.categories.*' => 'required',
                ]);

                break;
            case 3:
                $this->validate([
                    'proof_of_payment' => 'required',
                ]);

                break;
        }
    }
    public function save()
    {
        /* dd(
            $this->companies,
        ); */
        $this->resetErrorBag();
        $this->validateData();


        $subscriber_id = Subscriber::create([
            'name' => $this->owner_name,
            'email' => $this->owner_email,
            'phone' => $this->owner_phone,
        ])->id;
        foreach ($this->companies as $key => $company) {
            $company_logo_file_name = $company['name'] . '.' . $company['logo']->getClientOriginalExtension();
            $company_image_file_name = $company['name'] . '.' . $company['image']->getClientOriginalExtension();
            $company['logo']->storeAs('companies', $company_logo_file_name, 'public');
            $company['image']->storeAs('companies', $company_image_file_name, 'public');

            $proof_of_payment_file_name = $company['name'] . '.' . $this->proof_of_payment->getClientOriginalExtension();
            $this->proof_of_payment->storeAs('companies/payments', $proof_of_payment_file_name, 'public');
            $links = explode(',', $company['socials']);
            for ($i = 0; $i < 3; $i++) {
                $socials[] = $links[$i];
            }
            $plan = Plan::find($company['plan']);
            $isPremium = false;
            if ($plan->type == PlanTypeEnum::PREMIUM_A->value || $plan->type == PlanTypeEnum::PREMIUM_B->value || $plan->type == PlanTypeEnum::PREMIUM_C->value) {
                $isPremium = true;
            }
            $duration = $plan->duration;
            if ($this->redeemed_coupon) {
                if ($this->redeemed_coupon->discount_type == 'free_subscription') {
                    $duration = $plan->duration + $this->redeemed_coupon->subscription_duration;
                }
                $this->redeemed_coupon->update([
                    'redemption_count' => $this->redeemed_coupon->redemption_count++
                ]);
            }
            $due_date = Carbon::now()->addMonths($duration);
            if ($plan->billing_cycle === 'yearly') {
                $due_date = Carbon::now()->addYears($duration);
            }

            $subscriber_company_id = SubscriberCompany::create([
                'subscriber_id' => $subscriber_id,
                'logo' => 'companies/' . $company_logo_file_name,
                'image' => 'companies/' . $company_image_file_name,
                'name' => $company['name'],
                'address' => $company['address'],
                'phone' => $company['phone'],
                'price_range' => $company['from'] . ' - ' . $company['to'],
                'description' => $company['description'],
                'socials' => $socials,
            ])->id;
            $loop = 0;
            foreach ($company['categories'] as $key => $category) {
                if ($plan->categories == $loop) {
                    break;
                }
                $loop++;
                SubscriberCompanyCategory::create([
                    'subscriber_company_id' => $subscriber_company_id,
                    'category_id' => $key
                ]);
            }


            Payment::create([
                'subscriber_company_id' => $subscriber_company_id,
                'plan_id' => $plan->id,
                'proof_of_payment' => 'companies/payments/' . $proof_of_payment_file_name,
                'total' => $plan->price,
                'due_date' => $due_date,
                'latest' => true,
                'isPremium' => $isPremium,
            ]);
            session()->flash('success', 'Your application has been sent. Please wait for the confirmation.');

            $this->redirect('/suppliers');
        }
    }

    public function claimCoupon()
    {
        $this->resetErrorBag();
        try {
            $coupon = Coupon::where('code', $this->coupon)->first();
            if (!$coupon) {
                dd('null');
                $this->coupon = null;
                $this->addError('invalid_coupon', 'Invalid Coupon');
            }
            if ($coupon->redemption_count > $coupon->max_redemptions) {
                dd('max');
                $this->coupon = null;
                $this->addError('invalid_coupon', 'Redemption Limit Reached!');
            }
            if ($coupon->expiry_date) {
                if (Carbon::parse($coupon->expiry_date)->lt(now())) {
                    dd('expired');
                    $this->coupon = null;
                    $this->addError('invalid_coupon', 'Coupon is Expired');
                }
            }
            if ($coupon) {
                $this->redeemed_coupon = $coupon;
                $this->getPayments();
                $this->addError('coupon', 'Successfully Redeemed Coupon');
            }
        } catch (\Throwable $th) {
            $this->addError('invalid_coupon', $th->getMessage());
        }
    }

    private function getPayments($value = null)
    {
        foreach ($this->companies as $key => $company) {
            $plan_ids[] = $company['plan'];
        }
        $this->selected_plans = Plan::find($plan_ids);
        $this->selected_plan_sum = 0;
        foreach ($this->selected_plans as $key => $plan) {
            $this->selected_plan_sum += $plan->price;
        }
        if ($this->redeemed_coupon) {
            if ($this->redeemed_coupon->discount_type == DiscountTypeEnum::FIXED_AMOUNT) {
                $this->selected_plan_sum = $this->selected_plan_sum - $this->redeemed_coupon->discount_value;
            }
        }
    }

    public function increaseStep()
    {
        // dd(
        //     $this->companies,
        // );
        $this->resetErrorBag();
        $this->validateData();


        $this->current_step++;

        if ($this->current_step >= $this->total_step) {
            $this->current_step = $this->total_step;
        }
        if ($this->current_step === $this->total_step) {
            $this->getPayments();
        }
    }
    public function decreaseStep()
    {
        $this->resetErrorBag();

        $this->current_step--;

        if ($this->current_step < 0) {
            $this->current_step = 1;
        }
    }

    public function render()
    {
        if ($this->current_step === 2) {
            if ($this->companies) {
                $this->reset('selected_plans_array');
                foreach ($this->companies as $key => $company) {
                    if (array_key_exists("plan", $company)) {
                        $this->selected_plans_array[] = Plan::find($company['plan']);
                    }
                }
            }
            // dd($this->selected_plans_array[0]);
        }
        return view('livewire.pages.suppliers.create');
    }
}
