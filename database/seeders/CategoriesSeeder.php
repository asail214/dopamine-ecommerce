<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Category;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'order' => 1,
            ],
            [
                'name' => 'Clothing',
                'slug' => 'clothing', 
                'order' => 2,
            ],
            [
                'name' => 'Books',
                'slug' => 'books',
                'order' => 3,
            ],
            [
                'name' => 'Home & Garden',
                'slug' => 'home-garden',
                'order' => 4,
            ],
            [
                'name' => 'Sports',
                'slug' => 'sports',
                'order' => 5,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }
    }
}