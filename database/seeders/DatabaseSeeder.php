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
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ClientSeeder::class,
            PlanSeeder::class,
            SubscriberSeeder::class,
        ]);
    }
}
