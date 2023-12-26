<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory;
use App\Models\Plan;
use App\Models\Category;
use App\Models\Subscriber;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\SubscriberCompany;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 2; $i++) {

            Subscriber::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->phoneNumber(),
            ]);
        }
        $subscribers = Subscriber::all();
        $categories_count = Category::count();
        $plans_count = Plan::count();
        foreach ($subscribers as $key => $subscriber) {
            for ($i = 0; $i < 2; $i++) {
                $plan = Plan::find(random_int(1, $plans_count));
                $data = explode(' ', $plan->name);
                $subscription_duration = $data[0];
                $billing_cycle = $plan->billing_cycle;
                $due = Carbon::now()->addMonth($subscription_duration);
                if ($billing_cycle == 'yearly') {
                    $due = Carbon::now()->addYear($subscription_duration);
                }
                $category = Category::find(random_int(1, $categories_count));
                $array[] = [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                ];
                SubscriberCompany::create([
                    'subscriber_id' => $subscriber->id,
                    'plan_id' => $plan->id,
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
                    'categories' => $array,
                    'proof_of_payment' => $faker->imageUrl(),
                    'due_date' => $due,
                ]);
            }


        }
    }
}
