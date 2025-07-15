<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use TCG\Voyager\Models\Category;
use Illuminate\Support\Str;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('📦 Creating sample products...');

        // Sample products data with updated categories
        $products = [
            // Electronics
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Latest iPhone with advanced camera system and titanium design. Features A17 Pro chip, professional camera system, and all-day battery life.',
                'price' => 999.99,
                'compare_price' => 1099.99,
                'stock_quantity' => 50,
                'status' => 'active',
                'featured' => true,
                'category' => 'electronics'
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'description' => 'Powerful Android phone with AI features and excellent display. Galaxy AI brings advanced features to your fingertips.',
                'price' => 799.99,
                'compare_price' => 899.99,
                'stock_quantity' => 30,
                'status' => 'active',
                'featured' => true,
                'category' => 'electronics'
            ],
            [
                'name' => 'MacBook Air M3',
                'description' => 'Supercharged by the M3 chip, delivering exceptional performance and all-day battery life in an ultra-thin design.',
                'price' => 1299.99,
                'compare_price' => 1399.99,
                'stock_quantity' => 25,
                'status' => 'active',
                'featured' => true,
                'category' => 'electronics'
            ],
            [
                'name' => 'Sony WH-1000XM5 Headphones',
                'description' => 'Industry-leading noise canceling wireless headphones with crystal clear hands-free calling.',
                'price' => 399.99,
                'stock_quantity' => 40,
                'status' => 'active',
                'featured' => false,
                'category' => 'electronics'
            ],

            // Sports & Outdoors
            [
                'name' => 'Nike Air Max 270',
                'description' => 'Comfortable running shoes with modern design and Max Air unit for all-day comfort.',
                'price' => 150.00,
                'compare_price' => 180.00,
                'stock_quantity' => 100,
                'status' => 'active',
                'featured' => false,
                'category' => 'sports-outdoors'
            ],
            [
                'name' => 'Adidas Ultraboost 22',
                'description' => 'Premium running shoes with boost technology for energy return with every step.',
                'price' => 190.00,
                'stock_quantity' => 75,
                'status' => 'active',
                'featured' => false,
                'category' => 'sports-outdoors'
            ],
            [
                'name' => 'Yoga Mat Premium',
                'description' => 'Non-slip premium yoga mat made from eco-friendly materials. Perfect for all types of yoga and exercise.',
                'price' => 45.99,
                'stock_quantity' => 120,
                'status' => 'active',
                'featured' => false,
                'category' => 'sports-outdoors'
            ],

            // Clothing & Fashion
            [
                'name' => 'Levi\'s 501 Original Jeans',
                'description' => 'Classic straight-fit jeans, timeless style that never goes out of fashion.',
                'price' => 89.99,
                'compare_price' => 120.00,
                'stock_quantity' => 200,
                'status' => 'active',
                'featured' => false,
                'category' => 'clothing-fashion'
            ],
            [
                'name' => 'Premium Cotton T-Shirt',
                'description' => 'Soft cotton t-shirt available in multiple colors. Made from 100% organic cotton.',
                'price' => 25.99,
                'stock_quantity' => 500,
                'status' => 'active',
                'featured' => false,
                'category' => 'clothing-fashion'
            ],
            [
                'name' => 'Classic Leather Jacket',
                'description' => 'Genuine leather jacket with a timeless design. Perfect for any season.',
                'price' => 199.99,
                'compare_price' => 249.99,
                'stock_quantity' => 35,
                'status' => 'active',
                'featured' => true,
                'category' => 'clothing-fashion'
            ],

            // Books & Media
            [
                'name' => 'The Great Gatsby',
                'description' => 'Classic American novel by F. Scott Fitzgerald. A masterpiece of American literature.',
                'price' => 12.99,
                'stock_quantity' => 80,
                'status' => 'active',
                'featured' => false,
                'category' => 'books-media'
            ],
            [
                'name' => 'Programming Book Set',
                'description' => 'Complete guide to modern web development. Includes HTML, CSS, JavaScript, and React.',
                'price' => 79.99,
                'compare_price' => 99.99,
                'stock_quantity' => 40,
                'status' => 'active',
                'featured' => true,
                'category' => 'books-media'
            ],

            // Home & Garden
            [
                'name' => 'Garden Tool Set',
                'description' => 'Complete set of essential gardening tools including trowel, pruners, and weeder.',
                'price' => 45.99,
                'stock_quantity' => 60,
                'status' => 'active',
                'featured' => false,
                'category' => 'home-garden'
            ],
            [
                'name' => 'Smart Home Hub',
                'description' => 'Control your smart home devices from one place. Compatible with Alexa and Google Assistant.',
                'price' => 129.99,
                'compare_price' => 149.99,
                'stock_quantity' => 25,
                'status' => 'active',
                'featured' => true,
                'category' => 'electronics'
            ],
            [
                'name' => 'Indoor Plant Collection',
                'description' => 'Beautiful set of 3 air-purifying indoor plants perfect for home or office.',
                'price' => 39.99,
                'stock_quantity' => 45,
                'status' => 'active',
                'featured' => false,
                'category' => 'home-garden'
            ],

            // Health & Beauty
            [
                'name' => 'Skincare Set Premium',
                'description' => 'Complete skincare routine with cleanser, toner, serum, and moisturizer.',
                'price' => 89.99,
                'compare_price' => 120.00,
                'stock_quantity' => 55,
                'status' => 'active',
                'featured' => true,
                'category' => 'health-beauty'
            ],
            [
                'name' => 'Electric Toothbrush',
                'description' => 'Advanced electric toothbrush with multiple cleaning modes and long battery life.',
                'price' => 79.99,
                'stock_quantity' => 30,
                'status' => 'active',
                'featured' => false,
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

            // Remove category from product data
            unset($productData['category']);
            
            // Add required fields
            $productData['sku'] = 'DS-' . strtoupper(Str::random(6));
            $productData['slug'] = Str::slug($productData['name']);
            $productData['digital'] = false;
            $productData['requires_shipping'] = true;
            $productData['taxable'] = true;
            $productData['track_quantity'] = true;
            $productData['min_stock_level'] = 10;
            $productData['published_at'] = now();
            $productData['created_by'] = 1; // Assuming admin user ID is 1

            // Create product
            $product = Product::firstOrCreate(
                ['slug' => $productData['slug']],
                $productData
            );
            
            // Attach category if exists
            if ($category && !$product->categories->contains($category->id)) {
                $product->categories()->attach($category->id);
            }

            $createdCount++;
        }

        $this->command->info("✅ Created {$createdCount} products with category relationships");
    }
}