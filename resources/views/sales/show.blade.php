<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sale Details') }} #{{ $sale->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between mb-8 border-b pb-4">
                    <div>
                        <h3 class="text-2xl font-bold">Pro-Stream POS Receipt</h3>
                        <p class="text-gray-500">Transaction Date: {{ $sale->created_at->format('M d, Y H:i:s') }}</p>
                        <p class="text-gray-500">Cashier: {{ $sale->user->name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-500 uppercase">Status</p>
                        <p class="text-lg font-bold text-green-600">COMPLETED</p>
                    </div>
                </div>

                <table class="min-w-full divide-y divide-gray-200 mb-8">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Quantity</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Unit Price</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($sale->orderItems as $item)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $item->product->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-center">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-right">${{ number_format($item->unit_price, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-right font-medium">${{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="flex justify-end">
                    <div class="w-full md:w-1/3 space-y-3">
                        <div class="flex justify-between text-gray-500">
                            <span>Subtotal:</span>
                            <span>${{ number_format($sale->total_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold border-t pt-3">
                            <span>Total:</span>
                            <span>${{ number_format($sale->total_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-500">
                            <span>Paid Amount:</span>
                            <span>${{ number_format($sale->paid_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-500">
                            <span>Change:</span>
                            <span>${{ number_format($sale->change_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-between">
                    <a href="{{ route('sales.index') }}" class="text-indigo-600 hover:text-indigo-900">
                        &larr; Back to History
                    </a>
                    <button onclick="window.print()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                        Print Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
