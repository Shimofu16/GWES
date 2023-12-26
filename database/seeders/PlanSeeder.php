<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Support\Str;
use App\Enums\BillingCycleEnum;
use App\Enums\DiscountTypeEnum;
use App\Models\Coupon;
use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 3; $i++) {
            $billing_cycle = $faker->randomElement(BillingCycleEnum::toArray());
            $count = $faker->numberBetween($min = 1, $max = 3);
            $plan = $count . ' ' . (($billing_cycle == "monthly") ? 'month' : 'year') . ($count > 1 ? 's' : '');
            Plan::create([
                'name' => $plan,
                'description' => $faker->text(),
                'price' => $faker->randomNumber(3),
                'billing_cycle' => $billing_cycle,
                'is_visible' => $faker->boolean(),
            ]);
        }

        Coupon::create([
            'code' => 'FISRTSUB',
            'description' => 'For first subscribers!',
            'discount_type' => DiscountTypeEnum::FREE_SUBSCRIPTION->value,
            'subscription_duration' => 1,
            'start_date' => now(),
            'expiry_date' => now()->addWeeks(1),
            'max_redemptions' => 30,
        ]);
    }
}
