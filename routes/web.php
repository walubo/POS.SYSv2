<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    $totalSales = Sale::sum('total_amount');
    $todaySales = Sale::whereDate('created_at', Carbon::today())->sum('total_amount');
    $totalTransactions = Sale::count();
    $lowStockProducts = Product::where('stock', '<', 10)->count();

    $recentSales = Sale::with('user')->latest()->take(5)->get();

    return view('dashboard', compact('totalSales', 'todaySales', 'totalTransactions', 'lowStockProducts', 'recentSales'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Route::resource('categories', CategoryController::class); // Coming soon
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/add-stock', [ProductController::class, 'addStock'])->name('products.addStock');
});

Route::middleware(['auth'])->group(function () {
    Route::get('sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
});

require __DIR__.'/auth.php';
