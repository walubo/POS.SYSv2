<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where(function($q) {
            $q->where('pos_environment_id', auth()->user()->pos_environment_id)
              ->orWhereNull('pos_environment_id');
        });
        
        if ($request->filter === 'low_stock') {
            $query->where('stock', '<', 10);
        }
        
        $products = $query->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::whereNull('pos_environment_id')
            ->orWhere('pos_environment_id', auth()->user()->pos_environment_id)
            ->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if ($request->filled('new_category')) {
            $category = Category::create([
                'name' => $request->new_category,
                'pos_environment_id' => auth()->user()->pos_environment_id,
            ]);
            $request->merge(['category_id' => $category->id]);
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['pos_environment_id'] = auth()->user()->pos_environment_id;

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::whereNull('pos_environment_id')
            ->orWhere('pos_environment_id', auth()->user()->pos_environment_id)
            ->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($request->filled('new_category')) {
            $category = Category::create([
                'name' => $request->new_category,
                'pos_environment_id' => auth()->user()->pos_environment_id,
            ]);
            $request->merge(['category_id' => $category->id]);
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function addStock(Request $request, Product $product)
    {
        $request->validate([
            'amount' => 'required|integer|min:1',
        ]);

        $product->stock += $request->amount;
        $product->save();

        return back()->with('success', "Added {$request->amount} stock to {$product->name}. New stock: {$product->stock}");
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
