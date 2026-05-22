<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoController;

// Demo Mode Entry/Exit Routes
Route::get('/demo/enter', [DemoController::class, 'enter'])->name('demo.enter');
Route::get('/demo/leave', [DemoController::class, 'leave'])->name('demo.leave');

// Smart redirect: authenticated users go to dashboard, guests go to login
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});


use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;

// Environment Routes (No environment required to access these)
use App\Http\Controllers\EnvironmentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;

Route::middleware(['auth'])->group(function () {
    Route::get('/environment/create', [EnvironmentController::class, 'create'])->name('environment.create');
    Route::post('/environment/store', [EnvironmentController::class, 'store'])->name('environment.store');
    Route::get('/environment/join', [EnvironmentController::class, 'join'])->name('environment.join');
    Route::post('/environment/join', [EnvironmentController::class, 'processJoin'])->name('environment.processJoin');
    
    // Auth-only Demo actions
    Route::post('/demo/update-names', [DemoController::class, 'updateNames'])->name('demo.updateNames');
    Route::get('/demo/simulate', [DemoController::class, 'simulate'])->name('demo.simulate');
    Route::get('/demo/reset', [DemoController::class, 'reset'])->name('demo.reset');
    Route::post('/demo/add-employee', [DemoController::class, 'addEmployee'])->name('demo.addEmployee');
});

// Routes requiring an environment
Route::middleware(['auth', 'verified', \App\Http\Middleware\EnsureHasEnvironment::class])->group(function () {

    Route::get('/dashboard', function () {
        $envId = auth()->user()->pos_environment_id;
        
        $totalSales = Sale::where('pos_environment_id', $envId)->sum('total_amount');
        $todaySales = Sale::where('pos_environment_id', $envId)->whereDate('created_at', Carbon::today())->sum('total_amount');
        $totalTransactions = Sale::where('pos_environment_id', $envId)->count();
        $lowStockProducts = Product::where(function($q) use ($envId) {
            $q->where('pos_environment_id', $envId)
              ->orWhereNull('pos_environment_id');
        })->where('stock', '<', 10)->count();

        $recentSales = Sale::with('user')->where('pos_environment_id', $envId)->latest()->take(5)->get();

        $environment = \App\Models\PosEnvironment::find($envId);
        $employees = \App\Models\User::where('pos_environment_id', $envId)
            ->where('role', '!=', 'admin')
            ->withSum('sales', 'total_amount')
            ->get();

        return view('dashboard', compact('totalSales', 'todaySales', 'totalTransactions', 'lowStockProducts', 'recentSales', 'environment', 'employees'));
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/environment/rotate-code', [EnvironmentController::class, 'rotateCode'])->name('environment.rotateCode');
    Route::post('/environment/kick-employee/{user}', [EnvironmentController::class, 'kickEmployee'])->name('environment.kickEmployee');



    Route::middleware(['role:admin'])->group(function () {
        Route::resource('products', ProductController::class);
        Route::post('products/{product}/add-stock', [ProductController::class, 'addStock'])->name('products.addStock');
        Route::resource('categories', CategoryController::class);
    });

    Route::get('sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
});

require __DIR__.'/auth.php';
