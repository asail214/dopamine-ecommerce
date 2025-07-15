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
        $this->command->info('🚀 Starting database seeding...');

        // 1. Install Voyager core tables (users, roles, permissions, etc.)
        $this->call([
            DataTypesTableSeeder::class,
            DataRowsTableSeeder::class,
            MenusTableSeeder::class,
            MenuItemsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
            PermissionRoleTableSeeder::class,
            SettingsTableSeeder::class,
            UsersTableSeeder::class,  // Create admin user
        ]);

        // 2. Set up Categories (BREAD + data)
        $this->call([
            CategoriesTableSeeder::class,  // Creates BREAD structure for categories
            CategoriesSeeder::class,       // Adds sample categories
        ]);

        // 3. Set up Products (BREAD + data)
        $this->call([
            ProductsBreadSeeder::class,    // Creates BREAD structure for products
            ProductsSeeder::class,         // Adds sample products
        ]);

        // 4. Add other content
        $this->call([
            PostsTableSeeder::class,       // Blog posts
            PagesTableSeeder::class,       // Static pages
        ]);

        $this->command->info('🎉 Database seeded successfully!');
        $this->command->info('📝 Admin credentials:');
        $this->command->info('   Email: admin@admin.com');
        $this->command->info('   Password: password');
        $this->command->info('🌐 Visit /admin to access Voyager panel');
        $this->command->info('🏠 Visit / to see your website');
    }
}