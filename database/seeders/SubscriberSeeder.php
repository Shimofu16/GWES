<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory;
use App\Models\Plan;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Subscriber;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\SubscriberCompany;
use App\Models\SubscriberCompanyCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        try {
            $faker = Factory::create();
            for ($i = 0; $i < 5; $i++) {
                Subscriber::create([
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail(),
                    'phone' => $faker->phoneNumber(),
                ]);
            }
            $plans_count = Plan::count();
            $subscribers = Subscriber::all();
            $categories_count = Category::count();
            foreach ($subscribers as $key => $subscriber) {
                for ($i = 0; $i < 2; $i++) {

                    $plan = Plan::find(random_int(1, $plans_count));
                    $subscription_duration = $plan->duration;
                    $billing_cycle = $plan->billing_cycle;
                    $due = Carbon::now()->addMonth($subscription_duration);
                    if ($billing_cycle == 'yearly') {
                        $due = Carbon::now()->addYear($subscription_duration);
                    }
                    $subscriber_company_id =  SubscriberCompany::create([
                        'subscriber_id' => $subscriber->id,
                        'logo' => $faker->imageUrl(),
                        'name' => $faker->company(),
                        'address' => $faker->address(),
                        'phone' => $faker->phoneNumber(),
                        'price_range' => random_int(10000, 30000) . ' - ' . random_int(30000, 60000),
                        'description' => $faker->text(),
                        'socials' => [
                            'facebook' => $faker->url(),
                            'instagram' => $faker->url(),
                        ],
                        ])->id;
                    Payment::create([
                        'subscriber_company_id' => $subscriber_company_id,
                        'plan_id' => $plan->id,
                        'proof_of_payment' => $faker->imageUrl(),
                        'due_date' => $due,
                        'total' => $plan->price,
                        'latest' => true
                    ]);
                    for ($i = 0; $i < $plan->categories; $i++) {
                        SubscriberCompanyCategory::create([
                            'subscriber_company_id' => $subscriber_company_id,
                            'category_id' =>  Category::find(random_int(1, $categories_count))->id,
                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
