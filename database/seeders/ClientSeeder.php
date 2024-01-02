<?php

namespace Database\Seeders;

use App\Models\Client;
use Carbon\Carbon;
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
            $groom_birthday = Carbon::parse($faker->dateTimeBetween('-50 years', '-28 years'));
            $bride_birthday = $groom_birthday->subYears(3);
            $client =  Client::create([
                'groom' => [
                    'name' => $faker->name,
                    'birthday' => $groom_birthday,
                    'age' => $groom_birthday->age,
                ],
                'bride' => [
                    'name' => $faker->name,
                    'birthday' => $bride_birthday,
                    'age' => $bride_birthday->age,
                ],
            ]);
            $start = Carbon::parse($faker->dateTimeBetween(now(), now()->addYears(2)));
            // dd([
            //     'coordinator_name' => $faker->name(),
            //     'type' => $faker->randomElements(['debut', 'wedding']),
            //     'province' => 'Laguna',
            //     'city' => $faker->city(),
            //     'address' => $faker->address(),
            //     'date_start' => $start,
            //     'date_end' => $start->addDay(),
            // ]);
            $client->events()->create([
                'coordinator_name' => $faker->name(),
                'address' => $faker->address(),
                'date_start' => $start,
                'date_end' => $start->addDay(),
            ]);
        }
    }
}
