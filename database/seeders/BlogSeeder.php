<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\SubscriberCompany;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        $suppliers = SubscriberCompany::pluck('name', 'id');
        try {
            foreach ($suppliers as $key => $supplier) {
                Blog::create([
                    'subscriber_company_id' => $key,
                    'title' => $faker->title,
                    'description' => $faker->realTextBetween(),
                    'images' => $faker->imageUrl(),
                    'date' => $faker->date
                ]);
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
