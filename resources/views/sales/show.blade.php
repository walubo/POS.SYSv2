<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-white leading-tight">
                {{ __('Sale Receipt') }} #{{ $sale->id }}
            </h2>
            <a href="{{ route('sales.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition">&larr; Back to Sales</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl" id="receipt-content">
                <!-- Receipt Header -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">POS.SYSv2</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Receipt #{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $sale->created_at->format('F j, Y \a\t g:i A') }}</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Cashier: <strong class="text-gray-700 dark:text-gray-300">{{ $sale->user->name }}</strong></p>
                        </div>
                        <div class="text-left sm:text-right">
                            <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Status</p>
                            <span class="inline-flex mt-1 items-center gap-1 px-3 py-1 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 text-sm font-bold rounded-full">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                COMPLETED
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Qty</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Unit Price</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($sale->orderItems as $item)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-medium">{{ $item->product->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 text-center">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 text-right">₱{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-semibold text-right">₱{{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Payment Summary -->
                <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-end">
                        <div class="w-full sm:w-72 space-y-3">
                            <div class="flex justify-between text-sm text-gray-500 dark:text-gray-400">
                                <span>Subtotal</span>
                                <span>₱{{ number_format($sale->total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-xl font-bold text-gray-900 dark:text-white border-t border-gray-200 dark:border-gray-700 pt-3">
                                <span>Total</span>
                                <span>₱{{ number_format($sale->total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-500 dark:text-gray-400">
                                <span>Cash Tendered</span>
                                <span>₱{{ number_format($sale->paid_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm font-semibold text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900 rounded-lg px-3 py-2">
                                <span>Change</span>
                                <span>₱{{ number_format($sale->change_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons (hidden when printing) -->
            <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4 no-print">
                <a href="{{ route('sales.index') }}" class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back to Sales History
                </a>
                <div class="flex items-center gap-3">
                    <a href="{{ route('sales.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        New Sale
                    </a>
                    <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold rounded-lg transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Print Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            nav, header, .no-print { display: none !important; }
            body { background: white !important; }
            #receipt-content { box-shadow: none !important; border: 1px solid #eee; }
        }
    </style>
</x-app-layout>
