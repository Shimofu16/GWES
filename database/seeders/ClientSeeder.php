<?php

namespace Database\Seeders;

use App\Models\Client;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}
