<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class PhilippinesCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Additional categories tailored to the Philippines market
        Category::firstOrCreate([
            'name' => 'Fresh Produce',
            'description' => 'Locally sourced fruits and vegetables',
        ]);
        Category::firstOrCreate([
            'name' => 'Local Snacks',
            'description' => 'Popular Filipino street food and snacks',
        ]);
        Category::firstOrCreate([
            'name' => 'Handicrafts',
            'description' => 'Traditional Filipino crafts and souvenirs',
        ]);
        Category::firstOrCreate([
            'name' => 'Beverages',
            'description' => 'Soft drinks, juices, and local brewed drinks',
        ]);
        Category::firstOrCreate([
            'name' => 'Home & Living',
            'description' => 'Household items and décor',
        ]);
    }
}
