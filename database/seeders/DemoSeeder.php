<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\PosEnvironment;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Demo Admin User
        $admin = User::create([
            'name' => 'Juan dela Cruz',
            'email' => 'demo-admin@prostream.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // 2. Create Demo POS Environment
        $environment = PosEnvironment::create([
            'admin_id' => $admin->id,
            'join_code' => 'DEMO12',
            'code_updated_at' => now(),
        ]);

        // 3. Link Admin to Environment
        $admin->update(['pos_environment_id' => $environment->id]);

        // 4. Create Demo Cashier User
        User::create([
            'name' => 'Maria Santos',
            'email' => 'demo-cashier@prostream.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
            'pos_environment_id' => $environment->id,
            'email_verified_at' => now(),
        ]);

        // 5. Create Demo Categories (linked to Environment)
        $categories = [
            'Fresh Produce' => 'Locally sourced fruits and vegetables from Philippine farms',
            'Local Snacks' => 'Popular Filipino snacks, street food, and delicacies',
            'Beverages' => 'Refreshing local juices, traditional brews, and beers',
            'Handicrafts' => 'Beautiful handmade traditional Filipino crafts and decor',
            'Home & Living' => 'Essential Filipino household items and products',
        ];

        $categoryModels = [];
        foreach ($categories as $name => $desc) {
            $categoryModels[$name] = Category::create([
                'name' => $name,
                'description' => $desc,
                'pos_environment_id' => $environment->id,
            ]);
        }

        // 6. Create Philippine-centric Demo Products
        $products = [
            // Fresh Produce
            [
                'category' => 'Fresh Produce',
                'name' => 'Carabao Mangoes (1kg)',
                'price' => 180.00,
                'stock' => 12,
                'sku' => 'PROD-MANGO',
                'description' => 'Sweet, famous Guimaras carabao mangoes',
            ],
            [
                'category' => 'Fresh Produce',
                'name' => 'Calamansi (1kg)',
                'price' => 90.00,
                'stock' => 40,
                'sku' => 'PROD-CALAMANSI',
                'description' => 'Fresh local citrus fruits for cooking or juice',
            ],
            [
                'category' => 'Fresh Produce',
                'name' => 'Saba Banana (1 bundle)',
                'price' => 60.00,
                'stock' => 8,
                'sku' => 'PROD-SABA',
                'description' => 'Perfect for banana cue or turon cooking',
            ],
            // Local Snacks
            [
                'category' => 'Local Snacks',
                'name' => 'Chicharon Bulaklak',
                'price' => 120.00,
                'stock' => 25,
                'sku' => 'SNACK-CHICHARON',
                'description' => 'Crispy deep-fried pork ruffle fat',
            ],
            [
                'category' => 'Local Snacks',
                'name' => 'Boy Bawang Cornick',
                'price' => 25.00,
                'stock' => 150,
                'sku' => 'SNACK-BOYBAWANG',
                'description' => 'Garlic flavored crispy corn snack',
            ],
            [
                'category' => 'Local Snacks',
                'name' => 'Cebu Dried Mangoes (100g)',
                'price' => 150.00,
                'stock' => 9,
                'sku' => 'SNACK-DRIEDMANGO',
                'description' => 'Chewy and sweet dried mango slices from Cebu',
            ],
            [
                'category' => 'Local Snacks',
                'name' => 'Puto Seko',
                'price' => 45.00,
                'stock' => 35,
                'sku' => 'SNACK-PUTOSEKO',
                'description' => 'Traditional dry, powdery coconut cookies',
            ],
            // Beverages
            [
                'category' => 'Beverages',
                'name' => 'San Miguel Pale Pilsen',
                'price' => 75.00,
                'stock' => 80,
                'sku' => 'BEV-SANMIG',
                'description' => 'The iconic Filipino beer brand',
            ],
            [
                'category' => 'Beverages',
                'name' => 'Red Horse Beer (500ml)',
                'price' => 85.00,
                'stock' => 70,
                'sku' => 'BEV-REDHORSE',
                'description' => 'Extra strong local lager beer',
            ],
            [
                'category' => 'Beverages',
                'name' => 'Calamansi Juice (Bottle)',
                'price' => 35.00,
                'stock' => 110,
                'sku' => 'BEV-CALAMANSI',
                'description' => 'Sweetened refreshing local citrus juice',
            ],
            [
                'category' => 'Beverages',
                'name' => 'Barako Coffee Beans (250g)',
                'price' => 220.00,
                'stock' => 7,
                'sku' => 'BEV-BARAKO',
                'description' => 'Strong, aromatic Liberica coffee beans from Batangas',
            ],
            // Handicrafts
            [
                'category' => 'Handicrafts',
                'name' => 'Capiz Shell Coasters (Set of 4)',
                'price' => 350.00,
                'stock' => 15,
                'sku' => 'CRAFT-CAPIZ',
                'description' => 'Traditional coasters handcrafted from capiz shells',
            ],
            [
                'category' => 'Handicrafts',
                'name' => 'Banig Floor Mat (Medium)',
                'price' => 750.00,
                'stock' => 5,
                'sku' => 'CRAFT-BANIG',
                'description' => 'Handwoven mat made of pandan leaves',
            ],
            // Home & Living
            [
                'category' => 'Home & Living',
                'name' => 'Baguio Walis Tambo',
                'price' => 180.00,
                'stock' => 20,
                'sku' => 'HOME-WALISTAMBO',
                'description' => 'High-quality soft whisk broom from Baguio',
            ],
            [
                'category' => 'Home & Living',
                'name' => 'Walis Tingting',
                'price' => 50.00,
                'stock' => 50,
                'sku' => 'HOME-WALISTINGTING',
                'description' => 'Broomstick made of midribs of coconut leaves',
            ],
        ];

        foreach ($products as $p) {
            Product::create([
                'category_id' => $categoryModels[$p['category']]->id,
                'name' => $p['name'],
                'price' => $p['price'],
                'stock' => $p['stock'],
                'sku' => $p['sku'],
                'description' => $p['description'],
                'pos_environment_id' => $environment->id,
            ]);
        }
    }
}
