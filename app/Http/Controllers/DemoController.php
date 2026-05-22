<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Product;
use App\Models\Sale;
use App\Models\OrderItem;
use App\Models\PosEnvironment;

class DemoController extends Controller
{
    /**
     * Set up and enter Demo Mode.
     */
    public function enter()
    {
        $demoDbPath = database_path('demo.sqlite');

        // Create the demo database file if it doesn't exist
        if (!file_exists($demoDbPath)) {
            touch($demoDbPath);
        }

        // Dynamically switch configuration
        Config::set('database.connections.sqlite.database', $demoDbPath);
        DB::purge('sqlite');

        // Check if tables are migrated. If not, run migrate and seed.
        $needsMigration = false;
        try {
            $needsMigration = !Schema::hasTable('users') || User::count() === 0;
        } catch (\Throwable $e) {
            $needsMigration = true;
        }

        if ($needsMigration) {
            Artisan::call('migrate:fresh', ['--force' => true]);
            Artisan::call('db:seed', [
                '--class' => 'Database\Seeders\DemoSeeder',
                '--force' => true
            ]);
        }

        // Store flag in session
        session(['demo_mode' => true]);

        // Find the seeded Demo Admin user
        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            Auth::login($admin);
        }

        return redirect()->route('dashboard')->with('success', 'Welcome to POS Demo Mode!');
    }

    /**
     * Leave Demo Mode and return to real database.
     */
    public function leave()
    {
        Auth::logout();
        session()->forget('demo_mode');
        
        return redirect()->route('login')->with('status', 'You have exited Demo Mode.');
    }

    /**
     * Reset Demo Mode database to initial state.
     */
    public function reset()
    {
        if (!session('demo_mode')) {
            return redirect()->route('login');
        }

        $demoDbPath = database_path('demo.sqlite');

        // Dynamic switch
        Config::set('database.connections.sqlite.database', $demoDbPath);
        DB::purge('sqlite');

        // Run clean fresh migration and seed
        Artisan::call('migrate:fresh', ['--force' => true]);
        Artisan::call('db:seed', [
            '--class' => 'Database\Seeders\DemoSeeder',
            '--force' => true
        ]);

        // Re-login the admin
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            Auth::login($admin);
        }

        return redirect()->route('dashboard')->with('success', 'Demo database has been successfully reset.');
    }

    /**
     * Update Admin and/or Cashier names inside Demo Mode.
     */
    public function updateNames(Request $request)
    {
        if (!session('demo_mode')) {
            return redirect()->route('login');
        }

        $request->validate([
            'admin_name' => 'nullable|string|max:100',
            'cashier_name' => 'nullable|string|max:100',
        ]);

        $envId = auth()->user()->pos_environment_id;

        // Update Admin
        if ($request->filled('admin_name')) {
            $admin = User::where('pos_environment_id', $envId)
                ->where('role', 'admin')
                ->first();
            if ($admin) {
                $admin->update(['name' => $request->input('admin_name')]);
            }
        }

        // Update Cashier
        if ($request->filled('cashier_name')) {
            $cashier = User::where('pos_environment_id', $envId)
                ->where('role', 'cashier')
                ->first();
            if ($cashier) {
                $cashier->update(['name' => $request->input('cashier_name')]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Names updated successfully.');
    }

    /**
     * Add a cashier employee inside Demo Mode.
     */
    public function addEmployee(Request $request)
    {
        if (!session('demo_mode')) {
            return redirect()->route('login');
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'password' => 'required|string|min:8',
        ]);

        $envId = auth()->user()->pos_environment_id;

        // Check if user already exists in demo DB
        if (User::where('email', $request->email)->exists()) {
            return back()->with('error', 'An employee with this email already exists in the demo database.');
        }

        // Create the user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'cashier',
            'pos_environment_id' => $envId,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', "Demo cashier '{$request->name}' added successfully.");
    }

    /**
     * Simulate a cashier transaction in the background.
     */
    public function simulate()
    {
        if (!session('demo_mode')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $envId = auth()->user()->pos_environment_id;

        // Get a random Cashier from the environment
        $cashiers = User::where('pos_environment_id', $envId)
            ->where('role', 'cashier')
            ->get();

        $cashier = $cashiers->isNotEmpty() ? $cashiers->random() : null;

        // Fallback to admin if cashier not found
        $userId = $cashier ? $cashier->id : auth()->id();
        $cashierName = $cashier ? $cashier->name : auth()->user()->name;

        // Get available products that have stock
        $products = Product::where('pos_environment_id', $envId)
            ->where('stock', '>', 0)
            ->get();

        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No products available with stock. Restock items to continue simulation.',
            ]);
        }

        // Randomly pick 1 to 3 items
        $numItems = rand(1, min(3, $products->count()));
        $chosenProducts = $products->random($numItems);
        if ($chosenProducts instanceof Product) {
            $chosenProducts = collect([$chosenProducts]);
        }

        $totalAmount = 0;
        $orderItemsData = [];
        $lowStockAlerts = [];
        $itemsSoldSummary = [];

        foreach ($chosenProducts as $product) {
            $qty = rand(1, min(3, $product->stock));
            
            // Deduct stock
            $product->stock -= $qty;
            $product->save();

            $subtotal = $product->price * $qty;
            $totalAmount += $subtotal;

            $orderItemsData[] = [
                'product_id' => $product->id,
                'quantity' => $qty,
                'unit_price' => $product->price,
                'subtotal' => $subtotal,
            ];

            $itemsSoldSummary[] = [
                'name' => $product->name,
                'quantity' => $qty,
                'price' => number_format($product->price, 2),
            ];

            // Check if stock fell below 10
            if ($product->stock < 10) {
                $lowStockAlerts[] = [
                    'name' => $product->name,
                    'stock' => $product->stock,
                ];
            }
        }

        // Create Sale
        $paidAmount = ceil($totalAmount / 50) * 50;
        if ($paidAmount < $totalAmount) {
            $paidAmount += 50;
        }
        $changeAmount = $paidAmount - $totalAmount;

        $sale = Sale::create([
            'user_id' => $userId,
            'pos_environment_id' => $envId,
            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'change_amount' => $changeAmount,
        ]);

        foreach ($orderItemsData as $item) {
            $item['sale_id'] = $sale->id;
            OrderItem::create($item);
        }

        // Fetch new stats for DOM updates
        $totalSales = Sale::where('pos_environment_id', $envId)->sum('total_amount');
        $todaySales = Sale::where('pos_environment_id', $envId)->whereDate('created_at', now()->toDateString())->sum('total_amount');
        $totalTransactions = Sale::where('pos_environment_id', $envId)->count();
        $lowStockProducts = Product::where('pos_environment_id', $envId)->where('stock', '<', 10)->count();

        return response()->json([
            'success' => true,
            'cashier_name' => $cashierName,
            'total_amount' => number_format($totalAmount, 2),
            'items' => $itemsSoldSummary,
            'low_stock_alerts' => $lowStockAlerts,
            'timestamp' => now()->format('h:i:A'),
            'stats' => [
                'total_sales' => number_format($totalSales, 2),
                'today_sales' => number_format($todaySales, 2),
                'total_transactions' => $totalTransactions,
                'low_stock_products' => $lowStockProducts,
            ]
        ]);
    }
}
