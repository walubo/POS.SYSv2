<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Sale (POS)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Product Selection -->
                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium mb-4">Select Products</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($products as $product)
                                <div class="border rounded-lg p-4 flex flex-col justify-between hover:shadow-md transition-shadow">
                                    <div>
                                        <h4 class="font-bold text-gray-900">{{ $product->name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
                                        <p class="text-lg font-semibold text-blue-600 mt-2">${{ number_format($product->price, 2) }}</p>
                                        <p class="text-xs text-gray-400">Stock: {{ $product->stock }}</p>
                                    </div>
                                    <button type="button"
                                            onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, {{ $product->stock }})"
                                            class="mt-4 bg-green-500 hover:bg-green-600 text-white text-sm font-bold py-2 px-4 rounded">
                                        Add to Cart
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Cart & Checkout -->
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 sticky top-6">
                        <h3 class="text-lg font-medium mb-4">Cart</h3>
                        <form action="{{ route('sales.store') }}" method="POST" id="checkout-form">
                            @csrf
                            <div id="cart-items" class="mb-4 max-h-96 overflow-y-auto">
                                <!-- Cart items will be injected here -->
                                <p class="text-gray-500 text-center py-4" id="empty-cart-msg">Your cart is empty.</p>
                            </div>

                            <div class="border-t pt-4">
                                <div class="flex justify-between font-bold text-xl mb-4">
                                    <span>Total:</span>
                                    <span>$<span id="cart-total">0.00</span></span>
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="paid_amount" :value="__('Paid Amount')" />
                                    <x-text-input id="paid_amount" class="block mt-1 w-full" type="number" step="0.01" name="paid_amount" required oninput="calculateChange()" />
                                </div>

                                <div class="flex justify-between text-lg mb-6">
                                    <span>Change:</span>
                                    <span>$<span id="change-amount">0.00</span></span>
                                </div>

                                <x-primary-button class="w-full justify-center py-3" id="checkout-btn" disabled>
                                    {{ __('Process Sale') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = [];

        function addToCart(id, name, price, stock) {
            const existingItem = cart.find(item => item.id === id);
            if (existingItem) {
                if (existingItem.quantity < stock) {
                    existingItem.quantity++;
                } else {
                    alert('Cannot exceed available stock.');
                }
            } else {
                cart.push({ id, name, price, quantity: 1, stock });
            }
            renderCart();
        }

        function removeFromCart(id) {
            cart = cart.filter(item => item.id !== id);
            renderCart();
        }

        function updateQuantity(id, delta) {
            const item = cart.find(item => item.id === id);
            if (item) {
                const newQty = item.quantity + delta;
                if (newQty > 0 && newQty <= item.stock) {
                    item.quantity = newQty;
                } else if (newQty <= 0) {
                    removeFromCart(id);
                    return;
                }
            }
            renderCart();
        }

        function renderCart() {
            const cartContainer = document.getElementById('cart-items');
            const emptyMsg = document.getElementById('empty-cart-msg');
            const totalSpan = document.getElementById('cart-total');
            const checkoutBtn = document.getElementById('checkout-btn');

            cartContainer.innerHTML = '';
            let total = 0;

            if (cart.length === 0) {
                cartContainer.appendChild(emptyMsg);
                totalSpan.innerText = '0.00';
                checkoutBtn.disabled = true;
                return;
            }

            cart.forEach((item, index) => {
                const subtotal = item.price * item.quantity;
                total += subtotal;

                const itemDiv = document.createElement('div');
                itemDiv.className = 'flex justify-between items-center mb-3 pb-3 border-b';
                itemDiv.innerHTML = `
                    <div class="flex-1">
                        <h5 class="font-bold text-sm">${item.name}</h5>
                        <p class="text-xs text-gray-500">$${item.price.toFixed(2)} x ${item.quantity}</p>
                        <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                        <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="button" onclick="updateQuantity(${item.id}, -1)" class="text-gray-500 hover:text-red-500 font-bold px-2 border rounded">-</button>
                        <span class="text-sm">${item.quantity}</span>
                        <button type="button" onclick="updateQuantity(${item.id}, 1)" class="text-gray-500 hover:text-green-500 font-bold px-2 border rounded">+</button>
                        <button type="button" onclick="removeFromCart(${item.id})" class="text-red-500 hover:text-red-700 ml-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                `;
                cartContainer.appendChild(itemDiv);
            });

            totalSpan.innerText = total.toFixed(2);
            checkoutBtn.disabled = false;
            calculateChange();
        }

        function calculateChange() {
            const total = parseFloat(document.getElementById('cart-total').innerText);
            const paid = parseFloat(document.getElementById('paid_amount').value) || 0;
            const changeSpan = document.getElementById('change-amount');
            const change = paid - total;
            changeSpan.innerText = Math.max(0, change).toFixed(2);
        }
    </script>
</x-app-layout>
