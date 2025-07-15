<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database in the correct order
     */
    public function run(): void
    {
        // 1. First: Install Voyager (users, roles, permissions, menus)
        $this->call([
            VoyagerDatabaseSeeder::class,
        ]);

        // 2. Second: Create categories (no dependencies)
        $this->call([
            CategoriesTableSeeder::class,
        ]);

        // 3. Third: Create sample categories data
        $this->call([
            CategoriesSeeder::class,
        ]);

        // 4. Fourth: Set up Products BREAD in Voyager
        $this->call([
            ProductsBreadSeeder::class,
        ]);

        // 5. Fifth: Create products (depends on categories)
        $this->call([
            ProductsSeeder::class,
        ]);

        // 6. Finally: Create dummy content (posts, pages, etc.)
        $this->call([
            VoyagerDummyDatabaseSeeder::class,
        ]);

        $this->command->info('🎉 Database seeded successfully!');
        $this->command->info('📝 Admin credentials:');
        $this->command->info('   Email: admin@admin.com');
        $this->command->info('   Password: password');
        $this->command->info('🌐 Visit /admin to access Voyager panel');
    }
}