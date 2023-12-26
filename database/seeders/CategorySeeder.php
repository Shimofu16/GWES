<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
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
    }
}
