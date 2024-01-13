<?php

namespace App\Livewire\Pages\Suppliers;

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
    // public $company_logos = [];
    // public $company_names = [];
    // public $company_addresses = [];
    // public $company_phones = [];
    // public $company_price_ranges = [];
    // public $company_descriptions = [];
    // public $company_socials = [];
    // public $company_plans = [];
    // public $company_categories = [];

    public $proof_of_payment;
    public $coupon;
    public $redeemed_coupon;


    public $plans;
    public $selected_plan_sum = 0;
    public $categories;
    public $selected_plans = [];

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
                    'owner_email' => ['required', 'string'],
                    'company_count' => 'required',
                ]);
                break;
            case 2:
                /* $validator =   Validator::validate($this->companies, [
                    'companies.*.logo' => 'required',
                    'companies.*.name' => 'required',
                    'companies.*.address' => 'required',
                    'companies.*.phone' => 'required',
                    'companies.*.price_range' => 'required',
                    'companies.*.description' => 'required',
                    'companies.*.socials' => 'required',
                    'companies.*.plan' => 'required',
                    'companies.*.categories' => 'required',
                ]); */
                // $this->validate([
                //     'companies.*.logo' => 'required',
                //     'companies.*.name' => 'required',
                //     'companies.*.address' => 'required',
                //     'companies.*.phone' => 'required',
                //     'companies.*.price_range' => 'required',
                //     'companies.*.description' => 'required',
                //     'companies.*.socials' => 'required',
                //     'companies.*.plan' => 'required',
                //     'companies.*.categories' => 'required',
                // ]);
                // dd($validator);

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
                //     $this->company_categories,
                // );
                $this->validate([
                    'proof_of_payment' => ['required'],
                ]);

                break;
        }
    }
    public function save()
    {
        dd(
            $this->companies,
        );
        $this->resetErrorBag();
        $this->validateData();


        $subscriber_id = Subscriber::create([
            'name' => $this->owner_name,
            'email' => $this->owner_email,
            'phone' => $this->owner_phone,
        ])->id;

        for ($i = 0; $i < $this->company_count; $i++) {
            $company_file_name = $this->company_names[$i] . '.' . $this->company_logos[0]->getClientOriginalExtension();
            $this->company_logos[0]->storeAs('companies', $company_file_name, 'public');
            $proof_of_payment_file_name = $this->company_names[$i] . '.' . $this->proof_of_payment->getClientOriginalExtension();
            $this->proof_of_payment->storeAs('companies/payments', $proof_of_payment_file_name, 'public');
            $price_range = explode('-', $this->company_price_ranges[$i]);
            $socials = explode(',', $this->company_socials[$i]);
            $plan = Plan::find($this->company_plans[$i]);

            $duration = $plan->duration;
            if ($this->redeemed_coupon) {
                if ($this->redeemed_coupon->discount_type == 'free_subscription') {
                    $duration = $plan->duration + $this->redeemed_coupon->subscription_duration;
                }
            }
            $due_date = Carbon::now()->addMonths($duration);
            if ($plan->billing_cycle === 'yearly') {
                $due_date = Carbon::now()->addYears($duration);
            }

            $subscriber_company_id = SubscriberCompany::create([
                'subscriber_id' => $subscriber_id,
                'logo' => 'companies/' . $company_file_name,
                'name' => $this->company_names[$i],
                'address' => $this->company_addresses[$i],
                'phone' => $this->company_phones[$i],
                'price_range' => $price_range[0] . ' - ' . $price_range[1],
                'description' => $this->company_descriptions[$i],
                'socials' => $socials,
            ])->id;

            foreach ($this->company_categories[$i] as $key => $category) {
                SubscriberCompanyCategory::create([
                    'subscriber_company_id' => $subscriber_company_id,
                    'category_id' => $key
                ]);
            }
            $this->redeemed_coupon->update([
                'redemption_count' => $this->redeemed_coupon->redemption_count++
            ]);
            Payment::create([
                'subscriber_company_id' => $subscriber_company_id,
                'plan_id' => $plan->id,
                'proof_of_payment' => 'companies/payments/' . $proof_of_payment_file_name,
                'total' => $plan->price,
                'latest' => true,
                'due_date' => $due_date,
            ]);
            session()->flash('success', 'Your application has been sent. Please wait for the confirmation.');

            $this->redirect('/suppliers');
        }
    }

    public function claimCoupon()
    {
        $this->resetErrorBag();
        $coup = Coupon::where('code', $this->coupon)->first();
        if (!$coup) {
            $this->coupon = null;
            $this->addError('invalid_coupon', 'Invalid Coupon');
        } elseif ($coup->redemption_count > $coup->max_redemptions) {
            $this->coupon = null;
            $this->addError('invalid_coupon', 'Redemption Limit Reached!');
        } elseif (Carbon::parse($coup->expiry_date)->lt(now())) {
            $this->coupon = null;
            $this->addError('invalid_coupon', 'Coupon is Expired');
        } else {
            $this->redeemed_coupon = $coup;
            $this->addError('coupon', 'Successfully Redeem Coupon');
        }
    }

    private function getPayments()
    {
        foreach ($this->companies as $key => $company) {
            $plan_ids[] = $company['plan'];
        }
        $this->selected_plans = Plan::find($plan_ids);
    }

    public function increaseStep()
    {
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
