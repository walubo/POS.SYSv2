<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('user')->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($request) {
            $totalAmount = 0;
            $orderItemsData = [];

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    return redirect()->back()->withErrors(['error' => "Insufficient stock for {$product->name}"]);
                }

                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;

                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ];

                // Decrement stock
                $product->decrement('stock', $item['quantity']);
            }

            if ($request->paid_amount < $totalAmount) {
                return redirect()->back()->withErrors(['error' => 'Paid amount is less than total amount']);
            }

            $sale = Sale::create([
                'user_id' => auth()->id(),
                'total_amount' => $totalAmount,
                'paid_amount' => $request->paid_amount,
                'change_amount' => $request->paid_amount - $totalAmount,
            ]);

            foreach ($orderItemsData as $itemData) {
                $sale->orderItems()->create($itemData);
            }

            return redirect()->route('sales.index')->with('success', 'Sale processed successfully.');
        });
    }

    public function show(Sale $sale)
    {
        $sale->load(['orderItems.product', 'user']);
        return view('sales.show', compact('sale'));
    }
}
