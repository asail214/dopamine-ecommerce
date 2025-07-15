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
        // First, ensure we have categories
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics'],
            ['name' => 'Clothing', 'slug' => 'clothing'],
            ['name' => 'Books', 'slug' => 'books'],
            ['name' => 'Home & Garden', 'slug' => 'home-garden'],
            ['name' => 'Sports', 'slug' => 'sports'],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }

        // Sample products data
        $products = [
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Latest iPhone with advanced camera system and titanium design.',
                'price' => 999.99,
                'compare_price' => 1099.99,
                'stock_quantity' => 50,
                'status' => 'active',
                'featured' => true,
                'category' => 'electronics'
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'description' => 'Powerful Android phone with AI features and excellent display.',
                'price' => 799.99,
                'compare_price' => 899.99,
                'stock_quantity' => 30,
                'status' => 'active',
                'featured' => true,
                'category' => 'electronics'
            ],
            [
                'name' => 'Nike Air Max 270',
                'description' => 'Comfortable running shoes with modern design.',
                'price' => 150.00,
                'compare_price' => 180.00,
                'stock_quantity' => 100,
                'status' => 'active',
                'featured' => false,
                'category' => 'sports'
            ],
            [
                'name' => 'Adidas Ultraboost 22',
                'description' => 'Premium running shoes with boost technology.',
                'price' => 190.00,
                'stock_quantity' => 75,
                'status' => 'active',
                'featured' => false,
                'category' => 'sports'
            ],
            [
                'name' => 'Levi\'s 501 Jeans',
                'description' => 'Classic straight-fit jeans, timeless style.',
                'price' => 89.99,
                'compare_price' => 120.00,
                'stock_quantity' => 200,
                'status' => 'active',
                'featured' => false,
                'category' => 'clothing'
            ],
            [
                'name' => 'Cotton T-Shirt',
                'description' => 'Soft cotton t-shirt available in multiple colors.',
                'price' => 25.99,
                'stock_quantity' => 500,
                'status' => 'active',
                'featured' => false,
                'category' => 'clothing'
            ],
            [
                'name' => 'The Great Gatsby',
                'description' => 'Classic American novel by F. Scott Fitzgerald.',
                'price' => 12.99,
                'stock_quantity' => 80,
                'status' => 'active',
                'featured' => false,
                'category' => 'books'
            ],
            [
                'name' => 'Programming Book Set',
                'description' => 'Complete guide to modern web development.',
                'price' => 79.99,
                'compare_price' => 99.99,
                'stock_quantity' => 40,
                'status' => 'active',
                'featured' => true,
                'category' => 'books'
            ],
            [
                'name' => 'Garden Tool Set',
                'description' => 'Complete set of essential gardening tools.',
                'price' => 45.99,
                'stock_quantity' => 60,
                'status' => 'active',
                'featured' => false,
                'category' => 'home-garden'
            ],
            [
                'name' => 'Smart Home Hub',
                'description' => 'Control your smart home devices from one place.',
                'price' => 129.99,
                'compare_price' => 149.99,
                'stock_quantity' => 25,
                'status' => 'active',
                'featured' => true,
                'category' => 'electronics'
            ],
        ];

        foreach ($products as $productData) {
            // Find category
            $category = Category::where('slug', $productData['category'])->first();
            
            // Remove category from product data
            unset($productData['category']);
            
            // Add required fields
            $productData['sku'] = 'PRD-' . strtoupper(Str::random(8));
            $productData['slug'] = Str::slug($productData['name']);
            $productData['digital'] = false;
            $productData['requires_shipping'] = true;
            $productData['taxable'] = true;
            $productData['track_quantity'] = true;
            $productData['min_stock_level'] = 10;
            $productData['published_at'] = now();
            $productData['created_by'] = 1; // Assuming admin user ID is 1

            // Create product
            $product = Product::create($productData);
            
            // Attach category if exists
            if ($category) {
                $product->categories()->attach($category->id);
            }
        }
    }
}