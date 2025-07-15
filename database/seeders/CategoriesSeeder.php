<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Category;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🏷️ Creating sample categories...');

        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'order' => 1,
            ],
            [
                'name' => 'Clothing & Fashion',
                'slug' => 'clothing-fashion',
                'order' => 2,
            ],
            [
                'name' => 'Books & Media',
                'slug' => 'books-media',
                'order' => 3,
            ],
            [
                'name' => 'Home & Garden',
                'slug' => 'home-garden',
                'order' => 4,
            ],
            [
                'name' => 'Sports & Outdoors',
                'slug' => 'sports-outdoors',
                'order' => 5,
            ],
            [
                'name' => 'Health & Beauty',
                'slug' => 'health-beauty',
                'order' => 6,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }

        $this->command->info('✅ Created ' . count($categories) . ' categories');
    }
}