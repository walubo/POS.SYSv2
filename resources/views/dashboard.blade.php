<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500 uppercase">Total Sales</p>
                    <p class="text-3xl font-bold text-gray-900">${{ number_format($totalSales, 2) }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <p class="text-sm font-medium text-gray-500 uppercase">Today's Sales</p>
                    <p class="text-3xl font-bold text-green-600">${{ number_format($todaySales, 2) }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500 uppercase">Transactions</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalTransactions }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <p class="text-sm font-medium text-gray-500 uppercase">Low Stock Items</p>
                    <p class="text-3xl font-bold text-red-600">{{ $lowStockProducts }}</p>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Recent Transactions</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cashier</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($recentSales as $sale)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $sale->created_at->diffForHumans() }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $sale->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">${{ number_format($sale->total_amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('sales.show', $sale) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 italic">No transactions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($recentSales->count() > 0)
                    <div class="mt-4 text-right">
                        <a href="{{ route('sales.index') }}" class="text-sm text-blue-600 hover:underline">View all transactions &rarr;</a>
                    </div>
                @endif
            </div>

            <!-- Quick Links -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('sales.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white p-6 rounded-lg shadow-sm flex items-center justify-between group">
                    <div>
                        <h4 class="text-xl font-bold">Launch POS</h4>
                        <p class="text-indigo-100">Process new customer orders</p>
                    </div>
                    <svg class="w-8 h-8 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>

                @if(auth()->user()->role === 'admin')
                <a href="{{ route('products.create') }}" class="bg-white hover:bg-gray-50 text-gray-900 p-6 rounded-lg shadow-sm border flex items-center justify-between group">
                    <div>
                        <h4 class="text-xl font-bold">Add Product</h4>
                        <p class="text-gray-500">Update your inventory</p>
                    </div>
                    <svg class="w-8 h-8 text-gray-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
