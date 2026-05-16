<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-white leading-tight">
                {{ __('Edit Product') }}: {{ $product->name }}
            </h2>
            <a href="{{ route('products.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition">&larr; Back to Products</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6">
                <form action="{{ route('products.update', $product) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="name" :value="__('Product Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $product->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="category_id" :value="__('Category')" />
                            <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            
                            <div class="mt-3">
                                <x-input-label for="new_category" :value="__('Or Create New Category')" class="text-xs text-gray-500" />
                                <x-text-input id="new_category" class="block mt-1 w-full text-sm" type="text" name="new_category" :value="old('new_category')" placeholder="e.g. Beverages" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="sku" :value="__('Product Code / SKU')" />
                            <div class="flex gap-2 mt-1">
                                <x-text-input id="sku" class="block w-full" type="text" name="sku" :value="old('sku', $product->sku)" placeholder="e.g. 10293847" />
                                <button type="button" onclick="generateSKU()"
                                    class="shrink-0 inline-flex items-center gap-1.5 px-3 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-primary-100 dark:hover:bg-primary-900 border border-gray-300 dark:border-gray-600 hover:border-primary-400 dark:hover:border-primary-500 text-gray-700 dark:text-gray-300 hover:text-primary-700 dark:hover:text-primary-300 text-xs font-semibold rounded-lg transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    Regenerate
                                </button>
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Used for fast barcode/ID lookup in the POS.</p>
                            <x-input-error :messages="$errors->get('sku')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="price" :value="__('Price (₱)')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" min="0" name="price" :value="old('price', $product->price)" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="stock" :value="__('Stock Level')" />
                            <x-text-input id="stock" class="block mt-1 w-full" type="number" min="0" name="stock" :value="old('stock', $product->stock)" required />
                            <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-6">
                        <x-input-label for="description" :value="__('Description (optional)')" />
                        <textarea id="description" name="description" rows="4"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">{{ old('description', $product->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-100 dark:bg-red-900 hover:bg-red-200 dark:hover:bg-red-800 text-red-700 dark:text-red-300 font-semibold rounded-lg transition">
                                Delete Product
                            </button>
                        </form>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold rounded-lg transition">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Update Product') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function generateSKU() {
            const code = Math.floor(10000000 + Math.random() * 90000000).toString();
            document.getElementById('sku').value = code;
            document.getElementById('sku').focus();
        }
    </script>
</x-app-layout>
