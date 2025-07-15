<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use TCG\Voyager\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('📦 Creating sample products...');

        // Check available columns in products table
        $columns = Schema::getColumnListing('products');
        $this->command->info('Available product columns: ' . implode(', ', $columns));

        // Simple products data
        $products = [
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Latest iPhone with advanced camera system.',
                'price' => 999.99,
                'category' => 'electronics'
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'description' => 'Powerful Android phone with AI features.',
                'price' => 799.99,
                'category' => 'electronics'
            ],
            [
                'name' => 'Nike Air Max 270',
                'description' => 'Comfortable running shoes.',
                'price' => 150.00,
                'category' => 'sports-outdoors'
            ],
            [
                'name' => 'Levi\'s 501 Jeans',
                'description' => 'Classic straight-fit jeans.',
                'price' => 89.99,
                'category' => 'clothing-fashion'
            ],
            [
                'name' => 'The Great Gatsby',
                'description' => 'Classic American novel.',
                'price' => 12.99,
                'category' => 'books-media'
            ],
            [
                'name' => 'Garden Tool Set',
                'description' => 'Complete gardening tools.',
                'price' => 45.99,
                'category' => 'home-garden'
            ],
            [
                'name' => 'Skincare Set',
                'description' => 'Complete skincare routine.',
                'price' => 89.99,
                'category' => 'health-beauty'
            ],
        ];

        $createdCount = 0;

        foreach ($products as $productData) {
            // Find category
            $category = Category::where('slug', $productData['category'])->first();
            
            if (!$category) {
                $this->command->warn("⚠️ Category '{$productData['category']}' not found for product '{$productData['name']}'");
                continue;
            }

            // Prepare basic product data
            $slug = Str::slug($productData['name']);
            
            // Check if product already exists
            if (Product::where('slug', $slug)->exists()) {
                $this->command->info("ℹ️ Product already exists: {$productData['name']}");
                continue;
            }

            // Insert directly into database to avoid model complications
            $insertData = [
                'name' => $productData['name'],
                'description' => $productData['description'],
                'slug' => $slug,
                'price' => $productData['price'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Add optional fields if columns exist
            if (in_array('sku', $columns)) {
                $insertData['sku'] = 'DS-' . strtoupper(Str::random(6));
            }
            
            if (in_array('status', $columns)) {
                $insertData['status'] = 'active';
            }
            
            if (in_array('featured', $columns)) {
                $insertData['featured'] = rand(0, 1); // Random featured status
            }
            
            if (in_array('stock_quantity', $columns)) {
                $insertData['stock_quantity'] = rand(10, 100);
            }

            try {
                // Insert product
                $productId = DB::table('products')->insertGetId($insertData);
                
                // Create relationship with category
                if ($productId && $category) {
                    DB::table('category_product')->insert([
                        'category_id' => $category->id,
                        'product_id' => $productId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $createdCount++;
                $this->command->info("✅ Created product: {$productData['name']}");
                
            } catch (\Exception $e) {
                $this->command->error("❌ Failed to create product: {$productData['name']} - " . $e->getMessage());
            }
        }

        $this->command->info("✅ Products seeding completed! Created {$createdCount} new products with category relationships.");
    }
}