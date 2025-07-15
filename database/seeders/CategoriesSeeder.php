<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Category;
use Illuminate\Support\Facades\Schema;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        // Check if categories table exists before proceeding
        if (!Schema::hasTable('categories')) {
            $this->command->error('❌ Categories table does not exist. Make sure CategoriesTableSeeder runs first.');
            return;
        }

        $this->command->info('🏷️ Creating sample categories...');

        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'sort_order' => 1,
            ],
            [
                'name' => 'Clothing & Fashion',
                'slug' => 'clothing-fashion',
                'sort_order' => 2,
            ],
            [
                'name' => 'Books & Media',
                'slug' => 'books-media',
                'sort_order' => 3,
            ],
            [
                'name' => 'Home & Garden',
                'slug' => 'home-garden',
                'sort_order' => 4,
            ],
            [
                'name' => 'Sports & Outdoors',
                'slug' => 'sports-outdoors',
                'sort_order' => 5,
            ],
            [
                'name' => 'Health & Beauty',
                'slug' => 'health-beauty',
                'sort_order' => 6,
            ],
        ];

        $createdCount = 0;

        foreach ($categories as $categoryData) {
            $category = Category::firstOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
            
            if ($category->wasRecentlyCreated) {
                $createdCount++;
                $this->command->info("✅ Created category: {$categoryData['name']}");
            } else {
                $this->command->info("ℹ️ Category already exists: {$categoryData['name']}");
            }
        }

        $this->command->info("✅ Categories seeding completed! Created {$createdCount} new categories.");
    }
}