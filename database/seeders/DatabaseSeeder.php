<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\PlanAvailabilityEnum;
use Faker\Factory;
use App\Models\Plan;
use App\Models\User;
use App\Models\Event;
use App\Models\Client;
use App\Models\Category;
use App\Models\Subscriber;
use App\Models\SubscriberCompany;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'role' => 'admin',
            'email' => 'admin@app.com',
            'password' => Hash::make('password'),
        ]);
        $categories = [
            [
                'name' => 'Band',
                'slug' => 'brand',
            ],
            [
                'name' => 'Bridal Car',
                'slug' => 'bridal-car',
            ],
            [
                'name' => 'Cake & Pastry',
                'slug' => 'cake-pastry',
            ],
            [
                'name' => 'Catering & Services',
                'slug' => 'catering-services',
            ],
            [
                'name' => 'Coffee Bar',
                'slug' => 'coffee-bar',
            ],
            [
                'name' => 'Coordination',
                'slug' => 'coordination',
            ],
            [
                'name' => 'Crew Meal',
                'slug' => 'crew-meal',
            ],
            [
                'name' => 'Fireworks',
                'slug' => 'fireworks',
            ],
            [
                'name' => 'Florist & Stylist',
                'slug' => 'florist-stylist',
            ],
            [
                'name' => 'Food Carts',
                'slug' => 'food-carts',
            ],
            [
                'name' => 'Gown, Suits & Barong',
                'slug' => 'gown-suits-barong',
            ],
            [
                'name' => 'Grazing Bar',
                'slug' => 'grazing-bar',
            ],
            [
                'name' => 'Hair & Make-Up Artist',
                'slug' => 'hair-make-up-artist',
            ],
            [
                'name' => 'Host',
                'slug' => 'host',
            ],
            [
                'name' => 'Invitation',
                'slug' => 'invitation',
            ],
            [
                'name' => 'Lights & Sounds',
                'slug' => 'lights-sounds',
            ],
            [
                'name' => 'Mobile Bar',
                'slug' => 'mobile-bar',
            ],
            [
                'name' => 'Officiant',
                'slug' => 'officiant',
            ],
            [
                'name' => 'Photo & Video',
                'slug' => 'photo-video',
            ],
            [
                'name' => 'PhotoBooth',
                'slug' => 'photobooth',
            ],
            [
                'name' => 'Souveniers',
                'slug' => 'souveniers',
            ],
            [
                'name' => 'Venue',
                'slug' => 'venue',
            ],
            [
                'name' => 'Wedding Ring',
                'slug' => 'wedding-ring',
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $faker = Factory::create();
        for ($i = 0; $i < 5; $i++) {
            Client::create([
                'groom' => [
                    'name' => $faker->name,
                    'birthday' => $faker->date($format = 'Y-m-d', $max = 'now'),
                    'age' => $faker->numberBetween($min = 18, $max = 70),
                ],
                'bride' => [
                    'name' => $faker->name,
                    'birthday' => $faker->date($format = 'Y-m-d', $max = 'now'),
                    'age' => $faker->numberBetween($min = 18, $max = 70),
                ],
            ]);
        }

        $clients = Client::all();
        foreach ($clients as $key => $client) {
            for ($i = 0; $i < 2; $i++) {
                Event::create([
                    'client_id' => $client->id,
                    'coordinator_name' => $faker->name,
                    'type' => 'Wedding',
                    'city' => $faker->city(),
                    'address' => $faker->streetAddress(),
                    'date_start' => $faker->date($format = 'Y-m-d H:m:s', $max = 'now'),
                    'date_end' => $faker->date($format = 'Y-m-d H:m:s', $max = 'now'),
                ]);
            }
        }
        foreach (PlanAvailabilityEnum::cases() as $key => $case) {
            // to months
            $name =  $case->value . ' Month' . ($key != 0 ? 's' : '');
            $price = random_int(1000, 5000);
            $discount_price = random_int(500, 1500);
            $discount_percentage = $discount_price / $price * 100;
            Plan::create([
                'name' => $name,
                'description' => $faker->text(),
                'slug' => Str::slug($name),
                'is_visible' => true,
                'price' => $price,
                'discount_price' => $discount_price,
                'discount_percentage' => $discount_percentage,
                'availability' => $case->value,
            ]);
        }

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
            $plan = Plan::find(random_int(1, $plans_count));
            for ($i = 0; $i < 2; $i++) {
                $category = Category::find(random_int(1, $categories_count));
                $array[] = [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                ];
            }
            SubscriberCompany::create([
                'subscriber_id' => $subscriber->id,
                'plan_id' => $plan->id,
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
                'due_date' => Carbon::now()->addMonths($plan->availability)

            ]);
        }
    }
}
