<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::updateOrCreate(
            ['email' => 'admin@prostream.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Cashier User
        User::updateOrCreate(
            ['email' => 'cashier@prostream.com'],
            [
                'name' => 'Cashier User',
                'password' => Hash::make('password'),
                'role' => 'cashier',
            ]
        );

        // Sample Categories
        Category::create(['name' => 'Electronics', 'description' => 'Gadgets and devices']);
        Category::create(['name' => 'Food', 'description' => 'Snacks and drinks']);
        Category::create(['name' => 'Clothing', 'description' => 'Apparel and accessories']);

        // Call additional seeders for demo data
        $this->call([
            ProductsTableSeeder::class,
            PhilippinesCategoriesSeeder::class,
        ]);

    }
}
