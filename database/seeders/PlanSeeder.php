<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Support\Str;
use App\Enums\BillingCycleEnum;
use App\Enums\DiscountTypeEnum;
use App\Enums\PlanTypeEnum;
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
            $price = $faker->randomNumber(3);
            $billing_cycle = $faker->randomElement(BillingCycleEnum::toArray());
            $type = $faker->randomElement(PlanTypeEnum::toArray());
            $duration = $faker->numberBetween($min = 1, $max = 3);
            // $plan = $price . ' ' . (($billing_cycle == "monthly") ? 'month' : 'year') . ($duration > 1 ? 's' : '');
            $plan = 'Plan ' . $price;
            Plan::create([
                'name' => $plan,
                'price' => $price,
                'socials' => $duration,
                'duration' => $duration,
                'billing_cycle' => $billing_cycle,
                'type' => $type,
                'is_visible' => $faker->boolean(),
            ]);
        }

        Coupon::create([
            'code' => 'FISRTSUB',
            'discount_type' => DiscountTypeEnum::FREE_SUBSCRIPTION->value,
            'subscription_duration' => 1,
            'start_date' => now(),
            'expiry_date' => now()->addWeeks(1),
            'max_redemptions' => 30,
        ]);
    }
}
