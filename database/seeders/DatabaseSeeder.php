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
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@prostream.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Cashier User
        User::factory()->create([
            'name' => 'Cashier User',
            'email' => 'cashier@prostream.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
        ]);

        // Sample Categories
        Category::create(['name' => 'Electronics', 'description' => 'Gadgets and devices']);
        Category::create(['name' => 'Food', 'description' => 'Snacks and drinks']);
        Category::create(['name' => 'Clothing', 'description' => 'Apparel and accessories']);
    }
}
