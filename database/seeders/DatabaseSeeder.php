<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            VoyagerDatabaseSeeder::class,
            VoyagerDummyDatabaseSeeder::class,
            ProductsSeeder::class,
        ]);
    }
}