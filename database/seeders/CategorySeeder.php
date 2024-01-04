<?php

namespace Database\Seeders;

use App\Enums\CategoryTypeEnum;
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
                'type' => CategoryTypeEnum::ENTERTAINMENT->value
            ],
            [
                'name' => 'Bridal Car',
                'slug' => 'bridal-car',
                'type' => CategoryTypeEnum::TRANSPORTATION->value
            ],
            [
                'name' => 'Cake & Pastry',
                'slug' => 'cake-pastry',
                'type' => CategoryTypeEnum::FOODANDBEVERAGES->value
            ],
            [
                'name' => 'Catering & Services',
                'slug' => 'catering-services',
                'type' => CategoryTypeEnum::FOODANDBEVERAGES->value
            ],
            [
                'name' => 'Coffee Bar',
                'slug' => 'coffee-bar',
                'type' => CategoryTypeEnum::FOODANDBEVERAGES->value
            ],
            [
                'name' => 'Coordination',
                'slug' => 'coordination',
                'type' => CategoryTypeEnum::OTHERS->value
            ],
            [
                'name' => 'Crew Meal',
                'slug' => 'crew-meal',
                'type' => CategoryTypeEnum::FOODANDBEVERAGES->value
            ],
            [
                'name' => 'Fireworks',
                'slug' => 'fireworks',
                'type' => CategoryTypeEnum::ENTERTAINMENT->value
            ],
            [
                'name' => 'Florist & Stylist',
                'slug' => 'florist-stylist',
                'type' => CategoryTypeEnum::DECORATIONS->value
            ],
            [
                'name' => 'Food Carts',
                'slug' => 'food-carts',
                'type' => CategoryTypeEnum::FOODANDBEVERAGES->value
            ],
            [
                'name' => 'Gown, Suits & Barong',
                'slug' => 'gown-suits-barong',
                'type' => CategoryTypeEnum::ATTIRE->value
            ],
            [
                'name' => 'Grazing Bar',
                'slug' => 'grazing-bar',
                'type' => CategoryTypeEnum::FOODANDBEVERAGES->value
            ],
            [
                'name' => 'Hair & Make-Up Artist',
                'slug' => 'hair-make-up-artist',
                'type' => CategoryTypeEnum::OTHERS->value
            ],
            [
                'name' => 'Host',
                'slug' => 'host',
                'type' => CategoryTypeEnum::ENTERTAINMENT->value
            ],
            [
                'name' => 'Invitation',
                'slug' => 'invitation',
                'type' => CategoryTypeEnum::OTHERS->value
            ],
            [
                'name' => 'Lights & Sounds',
                'slug' => 'lights-sounds',
                'type' => CategoryTypeEnum::ENTERTAINMENT->value
            ],
            [
                'name' => 'Mobile Bar',
                'slug' => 'mobile-bar',
                'type' => CategoryTypeEnum::FOODANDBEVERAGES->value
            ],
            [
                'name' => 'Officiant',
                'slug' => 'officiant',
                'type' => CategoryTypeEnum::OTHERS->value
            ],
            [
                'name' => 'Photo & Video',
                'slug' => 'photo-video',
                'type' => CategoryTypeEnum::PHOTOGRAPHY->value
            ],
            [
                'name' => 'PhotoBooth',
                'slug' => 'photobooth',
                'type' => CategoryTypeEnum::PHOTOGRAPHY->value
            ],
            [
                'name' => 'Souveniers',
                'slug' => 'souveniers',
                'type' => CategoryTypeEnum::OTHERS->value
            ],
            [
                'name' => 'Venue',
                'slug' => 'venue',
                'type' => CategoryTypeEnum::OTHERS->value
            ],
            [
                'name' => 'Wedding Ring',
                'slug' => 'wedding-ring',
                'type' => CategoryTypeEnum::ATTIRE->value
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
