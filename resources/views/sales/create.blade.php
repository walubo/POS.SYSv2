<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-white leading-tight">
                {{ __('New Sale — POS') }}
            </h2>
            <a href="{{ route('sales.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition">&larr; Back to Sales</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Product Selection -->
                <div class="lg:col-span-2 space-y-4">
                    <!-- Search bar -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
                            </div>
                            <input type="text" id="product-search" placeholder="Search by name, product code, or category..."
                                class="w-full pl-10 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring-primary-500 rounded-lg shadow-sm text-sm"
                                oninput="filterProducts(this.value)">
                            <div id="search-results-info" class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 hidden"></div>
                        </div>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">💡 Tip: Type a product code (e.g. <code class="bg-gray-100 dark:bg-gray-700 px-1 rounded">10293847</code>) for instant lookup</p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Select Products</h3>
                        @if($products->isEmpty())
                            <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                <p class="font-medium">No products in stock</p>
                                <p class="text-sm mt-1">All products are out of stock or no products exist.</p>
                            </div>
                        @else
                            <div class="flex flex-wrap gap-4" id="products-grid">
                                @foreach ($products as $product)
                                    <div class="product-card w-full sm:w-[calc(50%-8px)] xl:w-[calc(33.333%-11px)] border border-gray-200 dark:border-gray-700 rounded-xl p-4 flex flex-col justify-between hover:shadow-md hover:border-primary-300 dark:hover:border-primary-600 transition-all"
                                         data-name="{{ strtolower($product->name) }}"
                                         data-category="{{ strtolower($product->category->name) }}"
                                         data-sku="{{ strtolower($product->sku ?? '') }}">
                                        <div>
                                            <div class="flex items-start justify-between mb-1">
                                                <h4 class="font-semibold text-gray-900 dark:text-white text-sm leading-tight">{{ $product->name }}</h4>
                                                <span class="text-xs px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-full ml-2 shrink-0">{{ $product->category->name }}</span>
                                            </div>
                                            @if($product->sku)
                                                <div class="flex items-center gap-1 mt-1 mb-2">
                                                    <svg class="w-3 h-3 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 3.5a.5.5 0 11-1 0 .5.5 0 011 0zM6 3.5a.5.5 0 11-1 0 .5.5 0 011 0z"/></svg>
                                                    <code class="text-xs font-mono text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 px-1.5 py-0.5 rounded tracking-wider">{{ $product->sku }}</code>
                                                </div>
                                            @endif
                                            <p class="text-xl font-bold text-primary-600 dark:text-primary-400">₱{{ number_format($product->price, 2) }}</p>
                                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                                <span class="{{ $product->stock < 5 ? 'text-red-500 dark:text-red-400 font-semibold' : '' }}">{{ $product->stock }} in stock</span>
                                            </p>
                                        </div>
                                        <button type="button"
                                                onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, {{ $product->stock }}, '{{ $product->sku ?? '' }}')"
                                                class="mt-3 w-full bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white text-sm font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                            Add to Cart
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Cart & Checkout -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl sticky top-6">
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Cart</h3>
                            <span id="cart-count" class="bg-primary-600 text-white text-xs font-bold px-2 py-1 rounded-full hidden">0</span>
                        </div>

                        <form action="{{ route('sales.store') }}" method="POST" id="checkout-form">
                            @csrf
                            <div class="p-4 max-h-80 overflow-y-auto min-h-[80px]">
                                <p class="text-gray-500 dark:text-gray-400 text-center py-6 text-sm" id="empty-cart-msg">Your cart is empty.</p>
                                <div id="cart-items"></div>
                            </div>

                            <div class="p-4 border-t border-gray-200 dark:border-gray-700 space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">Total:</span>
                                    <span class="text-2xl font-bold text-primary-600 dark:text-primary-400">₱<span id="cart-total">0.00</span></span>
                                </div>

                                <div>
                                    <label for="paid_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cash Tendered</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 font-bold">₱</span>
                                        <input id="paid_amount" type="number" step="0.01" min="0" name="paid_amount"
                                            class="block w-full pl-7 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring-primary-500 rounded-lg shadow-sm"
                                            placeholder="0.00" oninput="calculateChange()" />
                                    </div>
                                </div>

                                <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-700 rounded-lg px-4 py-3">
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Change:</span>
                                    <span class="text-lg font-bold text-green-600 dark:text-green-400">₱<span id="change-amount">0.00</span></span>
                                </div>

                                <button type="submit" id="checkout-btn" disabled
                                    class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-green-600 hover:bg-green-700 active:bg-green-800 text-white font-bold rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Process Sale
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = [];

        // ── Smart fuzzy search ────────────────────────────────────────────────
        function fuzzyMatch(text, query) {
            // Exact substring match first (fast path)
            if (text.includes(query)) return { match: true, score: 2 };
            // Fuzzy: all query chars must appear in order within text
            let ti = 0, qi = 0;
            while (ti < text.length && qi < query.length) {
                if (text[ti] === query[qi]) qi++;
                ti++;
            }
            return { match: qi === query.length, score: 1 };
        }

        function filterProducts(query) {
            const q = query.trim().toLowerCase();
            const info = document.getElementById('search-results-info');
            const cards = document.querySelectorAll('.product-card');
            let visible = 0;

            cards.forEach(card => {
                const name     = card.dataset.name     || '';
                const category = card.dataset.category || '';
                const sku      = card.dataset.sku      || '';

                if (!q) {
                    card.style.display = '';
                    card.style.order = '';
                    visible++;
                    return;
                }

                // SKU / product code: exact prefix match gets highest priority
                const skuExact = sku && sku.startsWith(q);
                const nameMatch     = fuzzyMatch(name, q);
                const categoryMatch = fuzzyMatch(category, q);
                const skuMatch      = sku ? fuzzyMatch(sku, q) : { match: false, score: 0 };

                const isMatch = skuExact || nameMatch.match || categoryMatch.match || skuMatch.match;

                if (isMatch) {
                    // Higher score = shown first
                    const score = (skuExact ? 10 : 0) + Math.max(
                        nameMatch.match     ? nameMatch.score * 3     : 0,
                        categoryMatch.match ? categoryMatch.score     : 0,
                        skuMatch.match      ? skuMatch.score  * 2     : 0
                    );
                    card.style.display = '';
                    card.style.order   = -score; // CSS order: lower = first
                    visible++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show result count
            if (q) {
                info.textContent = `${visible} result${visible !== 1 ? 's' : ''}`;
                info.classList.remove('hidden');
            } else {
                info.classList.add('hidden');
            }
        }

        function addToCart(id, name, price, stock, sku = '') {
            const existingItem = cart.find(item => item.id === id);
            if (existingItem) {
                if (existingItem.quantity < stock) {
                    existingItem.quantity++;
                } else {
                    alert(`Cannot add more — only ${stock} in stock.`);
                }
            } else {
                cart.push({ id, name, price, quantity: 1, stock, sku });
            }
            renderCart();
        }

        function removeFromCart(id) {
            cart = cart.filter(item => item.id !== id);
            renderCart();
        }

        function updateQuantity(id, delta) {
            const item = cart.find(item => item.id === id);
            if (!item) return;
            const newQty = item.quantity + delta;
            if (newQty <= 0) {
                removeFromCart(id);
                return;
            }
            if (newQty > item.stock) {
                alert(`Cannot exceed available stock (${item.stock}).`);
                return;
            }
            item.quantity = newQty;
            renderCart();
        }

        function renderCart() {
            const cartContainer = document.getElementById('cart-items');
            const emptyMsg = document.getElementById('empty-cart-msg');
            const totalSpan = document.getElementById('cart-total');
            const checkoutBtn = document.getElementById('checkout-btn');
            const cartCount = document.getElementById('cart-count');

            cartContainer.innerHTML = '';
            let total = 0;

            if (cart.length === 0) {
                emptyMsg.style.display = '';
                totalSpan.textContent = '0.00';
                checkoutBtn.disabled = true;
                cartCount.classList.add('hidden');
                document.getElementById('change-amount').textContent = '0.00';
                return;
            }

            emptyMsg.style.display = 'none';
            const totalItems = cart.reduce((sum, i) => sum + i.quantity, 0);
            cartCount.textContent = totalItems;
            cartCount.classList.remove('hidden');

            cart.forEach((item, index) => {
                const subtotal = item.price * item.quantity;
                total += subtotal;

                const itemDiv = document.createElement('div');
                itemDiv.className = 'flex items-center gap-3 mb-3 pb-3 border-b border-gray-100 dark:border-gray-700 last:border-0 last:mb-0 last:pb-0';
                itemDiv.innerHTML = `
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">${item.name}</p>
                        ${item.sku ? `<p class="text-xs font-mono text-gray-400 dark:text-gray-500">#${item.sku}</p>` : ''}
                        <p class="text-xs text-gray-500 dark:text-gray-400">₱${item.price.toFixed(2)} × ${item.quantity} = <strong>₱${subtotal.toFixed(2)}</strong></p>
                        <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                        <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                    </div>
                    <div class="flex items-center gap-1 shrink-0">
                        <button type="button" onclick="updateQuantity(${item.id}, -1)"
                            class="w-7 h-7 flex items-center justify-center border border-gray-300 dark:border-gray-600 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-red-50 dark:hover:bg-red-900 hover:text-red-600 dark:hover:text-red-400 hover:border-red-300 dark:hover:border-red-600 transition text-sm font-bold">−</button>
                        <span class="w-8 text-center text-sm font-bold text-gray-900 dark:text-white">${item.quantity}</span>
                        <button type="button" onclick="updateQuantity(${item.id}, 1)"
                            class="w-7 h-7 flex items-center justify-center border border-gray-300 dark:border-gray-600 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-green-50 dark:hover:bg-green-900 hover:text-green-600 dark:hover:text-green-400 hover:border-green-300 dark:hover:border-green-600 transition text-sm font-bold">+</button>
                        <button type="button" onclick="removeFromCart(${item.id})"
                            class="w-7 h-7 flex items-center justify-center text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition ml-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                `;
                cartContainer.appendChild(itemDiv);
            });

            totalSpan.textContent = total.toFixed(2);
            checkoutBtn.disabled = false;
            calculateChange();
        }

        function calculateChange() {
            const total = parseFloat(document.getElementById('cart-total').textContent) || 0;
            const paid = parseFloat(document.getElementById('paid_amount').value) || 0;
            const changeSpan = document.getElementById('change-amount');
            const checkoutBtn = document.getElementById('checkout-btn');

            const change = paid - total;
            changeSpan.textContent = Math.max(0, change).toFixed(2);

            // Only enable checkout if cart is not empty
            if (cart.length > 0) {
                checkoutBtn.disabled = false;
            }
        }

        // Prevent double submission
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            if (cart.length === 0) {
                e.preventDefault();
                alert('Your cart is empty.');
                return;
            }
            const total = parseFloat(document.getElementById('cart-total').textContent) || 0;
            const paid = parseFloat(document.getElementById('paid_amount').value) || 0;
            if (paid < total) {
                e.preventDefault();
                alert(`Cash tendered (₱${paid.toFixed(2)}) is less than total (₱${total.toFixed(2)}).`);
                return;
            }
            document.getElementById('checkout-btn').disabled = true;
            document.getElementById('checkout-btn').textContent = 'Processing...';
        });
    </script>
</x-app-layout>
