<?php

namespace Database\Seeders;

use App\Models\FeedBack;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeedBackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 5; $i++) {
            FeedBack::create([
                'context' => $faker->realText()
            ]);
        }
    }
}
