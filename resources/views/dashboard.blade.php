<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-white leading-tight">
                {{ __('Dashboard') }}
            </h2>
            @if(auth()->user()->role === 'admin' && $environment)
            <div class="flex items-center space-x-4 bg-gray-100 dark:bg-gray-700 px-4 py-2 rounded-lg">
                <span class="text-sm text-gray-500 dark:text-gray-300">Join Code:</span>
                <span class="font-bold text-xl tracking-widest text-primary-600 dark:text-primary-400">{{ $environment->join_code }}</span>
                <form action="{{ route('environment.rotateCode') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-white bg-red-500 hover:bg-red-600 px-3 py-1 rounded transition" title="Regenerate Code (does not kick active users)">
                        Rotate
                    </button>
                </form>
            </div>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Sales Card -->
                <a href="{{ route('sales.index') }}" class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6 border-l-4 border-primary-500 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total Sales</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">₱{{ number_format($totalSales, 2) }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">All time</p>
                        </div>
                        <div class="bg-primary-100 dark:bg-primary-900 p-3 rounded-full">
                            <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Today's Sales Card -->
                <a href="{{ route('sales.index', ['filter' => 'today']) }}" class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6 border-l-4 border-green-500 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Today's Sales</p>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">₱{{ number_format($todaySales, 2) }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Latest transactions</p>
                        </div>
                        <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Transactions Card -->
                <a href="{{ route('sales.index') }}" class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6 border-l-4 border-purple-500 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Transactions</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalTransactions }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total orders</p>
                        </div>
                        <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-full">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Low Stock Items Card -->
                <a href="{{ route('products.index', ['filter' => 'low_stock']) }}" class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6 border-l-4 border-red-500 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Low Stock Items</p>
                            <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">{{ $lowStockProducts }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Needs restocking</p>
                        </div>
                        <div class="bg-red-100 dark:bg-red-900 p-3 rounded-full">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Main Dashboard Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Recent Activity (Takes up 2 columns on large screens) -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Transactions</h3>
                        <a href="{{ route('sales.index') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium transition">
                            View all &rarr;
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Cashier</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($recentSales as $sale)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $sale->created_at->diffForHumans() }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">{{ $sale->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">₱{{ number_format($sale->total_amount, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('sales.show', $sale) }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400 italic">No transactions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quick Links & Actions -->
                <div class="space-y-6">
                    <a href="{{ route('sales.create') }}" class="block bg-gradient-to-br from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white p-6 rounded-xl shadow-md transition transform hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-xl font-bold text-white">Launch POS</h4>
                                <p class="text-primary-100 mt-1 text-sm">Process new customer orders</p>
                            </div>
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </div>
                    </a>

                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('products.create') }}" class="block bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-white p-6 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 transition transform hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-xl font-bold">Add Product</h4>
                                <p class="text-gray-600 dark:text-gray-400 mt-1 text-sm">Update your inventory</p>
                            </div>
                            <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                    </a>
                    @endif
                </div>
            </div>

            @if(auth()->user()->role === 'admin')
            <!-- Employee Management Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl mb-8">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Employee Performance</h3>
                    <p class="text-sm text-gray-500 mt-1">Manage cashiers in your POS environment</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Employee</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Joined Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Total Sales Driven</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($employees as $employee)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold">
                                                {{ substr($employee->name, 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $employee->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $employee->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                        {{ $employee->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600 dark:text-green-400">
                                        ₱{{ number_format($employee->sales_sum_total_amount ?? 0, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form action="{{ route('environment.kickEmployee', $employee) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this employee from your environment? They will need a new code to join again.');">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:hover:text-red-400 font-medium transition">
                                                Kick
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400 italic">No employees have joined your environment yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
