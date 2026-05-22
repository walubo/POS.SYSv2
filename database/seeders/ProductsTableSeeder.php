<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure categories exist (Electronics, Food, Clothing already seeded)
        $electronics = Category::firstWhere('name', 'Electronics');
        $food = Category::firstWhere('name', 'Food');
        $clothing = Category::firstWhere('name', 'Clothing');

        // Additional custom categories
        $books = Category::firstOrCreate(['name' => 'Books', 'description' => 'Printed and digital books']);
        $sports = Category::firstOrCreate(['name' => 'Sports', 'description' => 'Sporting goods and equipment']);

        // Demo products
        Product::firstOrCreate(
            ['sku' => 'ELEC-001'],
            [
                'category_id' => $electronics->id,
                'name' => 'Smartphone X10',
                'price' => 699.99,
                'stock' => 50,
                'description' => 'High-end smartphone with OLED display',
            ]
        );
        Product::firstOrCreate(
            ['sku' => 'ELEC-002'],
            [
                'category_id' => $electronics->id,
                'name' => 'Wireless Headphones',
                'price' => 199.99,
                'stock' => 120,
                'description' => 'Noise-cancelling over-ear headphones',
            ]
        );
        Product::firstOrCreate(
            ['sku' => 'FOOD-001'],
            [
                'category_id' => $food->id,
                'name' => 'Organic Coffee Beans',
                'price' => 14.99,
                'stock' => 200,
                'description' => 'Freshly roasted Arabica beans',
            ]
        );
        Product::firstOrCreate(
            ['sku' => 'CLOTH-001'],
            [
                'category_id' => $clothing->id,
                'name' => 'Denim Jacket',
                'price' => 89.99,
                'stock' => 30,
                'description' => 'Classic blue denim jacket',
            ]
        );
        Product::firstOrCreate(
            ['sku' => 'BOOK-001'],
            [
                'category_id' => $books->id,
                'name' => 'The Great Novel',
                'price' => 24.99,
                'stock' => 80,
                'description' => 'Bestselling fiction book',
            ]
        );
        Product::firstOrCreate(
            ['sku' => 'SPORT-001'],
            [
                'category_id' => $sports->id,
                'name' => 'Yoga Mat',
                'price' => 39.99,
                'stock' => 150,
                'description' => 'Eco-friendly non-slip yoga mat',
            ]
        );
    }
}
