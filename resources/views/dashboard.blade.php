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
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 rounded-xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-850 dark:text-red-200 rounded-xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Sales Card -->
                <a href="{{ route('sales.index') }}" class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6 border-l-4 border-primary-500 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total Sales</p>
                            <p id="stat-total-sales" class="text-3xl font-bold text-gray-900 dark:text-white mt-2">₱{{ number_format($totalSales, 2) }}</p>
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
                            <p id="stat-today-sales" class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">₱{{ number_format($todaySales, 2) }}</p>
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
                            <p id="stat-transactions" class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalTransactions }}</p>
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
                            <p id="stat-low-stock" class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">{{ $lowStockProducts }}</p>
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
                            <tbody id="recent-transactions-tbody" class="divide-y divide-gray-200 dark:divide-gray-700">
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

                    @if(session('demo_mode'))
                        <!-- Cashier Simulator Card -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 border border-gray-200 dark:border-gray-700 relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-3">
                                <span class="flex h-3 w-3">
                                    <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-green-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                                </span>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Cashier Simulator
                            </h4>
                            
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                Automatically simulates customer purchases to test the register in real-time.
                            </p>

                            <!-- Timer & Progress -->
                            <div class="mb-4">
                                <div class="flex justify-between text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">
                                    <span>NEXT SALE SIMULATION</span>
                                    <span id="demo-timer-text">05:00</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 h-2 rounded-full overflow-hidden">
                                    <div id="demo-progress-bar" class="bg-green-500 h-2 rounded-full transition-all duration-1000 ease-linear" style="width: 0%"></div>
                                </div>
                            </div>

                            <button id="simulate-now-btn" class="w-full bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-2.5 px-4 rounded-lg transition flex items-center justify-center gap-2 shadow-sm hover:shadow">
                                <svg id="simulate-btn-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                <span>Simulate Sale Now</span>
                            </button>
                        </div>

                        <!-- Rename Characters Card -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Rename Characters
                            </h4>
                            <form id="rename-form" action="{{ route('demo.updateNames') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="admin_name" class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Admin Name</label>
                                    <input type="text" name="admin_name" id="admin_name" value="{{ auth()->user()->name }}" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:ring-amber-500 focus:border-amber-500 shadow-sm">
                                </div>
                                <div>
                                    <label for="cashier_name" class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Cashier Name</label>
                                    <input type="text" name="cashier_name" id="cashier_name" value="{{ \App\Models\User::where('pos_environment_id', auth()->user()->pos_environment_id)->where('role', 'cashier')->first()?->name ?? 'Maria Santos' }}" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:ring-amber-500 focus:border-amber-500 shadow-sm">
                                </div>
                                <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold py-2 px-4 rounded-lg transition shadow-sm hover:shadow">
                                    Update Names
                                </button>
                            </form>
                        </div>

                        <!-- Live Cashier Activity Feed Card -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Live Activity Feed
                            </h4>
                            <div id="demo-activity-feed" class="space-y-3 overflow-y-auto pr-1 max-h-[300px] scrollbar-thin">
                                <!-- Feed items will be injected here -->
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if(auth()->user()->role === 'admin')
            <!-- Employee Management Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl mb-8">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Employee Performance</h3>
                        <p class="text-sm text-gray-500 mt-1">Manage cashiers in your POS environment</p>
                    </div>
                    @if(session('demo_mode'))
                        <button type="button" onclick="document.getElementById('add-employee-modal').classList.remove('hidden')" class="bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white text-xs font-semibold py-2 px-4 rounded-lg transition shadow-sm hover:shadow flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            Add Demo Cashier
                        </button>
                    @endif
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

    @if(session('demo_mode'))
        <!-- Toast Container -->
        <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-3 max-w-sm w-full pointer-events-auto"></div>

        <!-- Demo Mode Javascript -->
        <script>
            function escapeHtml(str) {
                if (typeof str !== 'string') return '';
                return str.replace(/&/g, "&amp;")
                          .replace(/</g, "&lt;")
                          .replace(/>/g, "&gt;")
                          .replace(/"/g, "&quot;")
                          .replace(/'/g, "&#039;");
            }

            function showToast(title, message, type = 'success') {
                const container = document.getElementById('toast-container');
                if (!container) return;

                const toast = document.createElement('div');
                toast.className = `transform translate-y-2 opacity-0 transition-all duration-500 ease-out flex items-start gap-3 p-4 rounded-xl shadow-lg border text-sm max-w-sm w-full ${
                    type === 'warning' 
                        ? 'bg-amber-50 border-amber-200 dark:bg-amber-900/30 dark:border-amber-800 text-amber-800 dark:text-amber-200' 
                        : 'bg-green-50 border-green-200 dark:bg-green-900/30 dark:border-green-800 text-green-800 dark:text-green-200'
                }`;

                const icon = type === 'warning'
                    ? `<svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>`
                    : `<svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`;

                toast.innerHTML = `
                    ${icon}
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-900 dark:text-white">${title}</p>
                        <p class="text-xs text-gray-650 dark:text-gray-400 mt-1">${message}</p>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 focus:outline-none shrink-0" onclick="this.parentElement.remove()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                `;

                container.appendChild(toast);

                setTimeout(() => {
                    toast.classList.remove('translate-y-2', 'opacity-0');
                }, 50);

                setTimeout(() => {
                    toast.classList.add('opacity-0', 'translate-y-2');
                    setTimeout(() => toast.remove(), 500);
                }, 5000);
            }

            let isSimulating = false;

            function triggerSimulation(isForced = false) {
                if (isSimulating) return;
                
                isSimulating = true;
                const btn = document.getElementById('simulate-now-btn');
                const icon = document.getElementById('simulate-btn-icon');
                
                if (btn) {
                    btn.disabled = true;
                    btn.classList.add('opacity-75', 'cursor-not-allowed');
                }
                if (icon) {
                    icon.classList.add('animate-spin');
                }
                
                fetch('{{ route("demo.simulate") }}', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateStats(data.stats);
                        addActivityToFeed(data);
                        prependToTransactionsTable(data);
                        
                        const itemsList = data.items.map(item => `${item.quantity}x ${item.name}`).join(', ');
                        showToast('Simulated Sale', `${data.cashier_name} completed a sale of ₱${data.total_amount} (${itemsList})`, 'success');
                        
                        if (data.low_stock_alerts && data.low_stock_alerts.length > 0) {
                            data.low_stock_alerts.forEach(alert => {
                                showToast('Low Stock Alert', `${alert.name} is running low on stock! (${alert.stock} remaining)`, 'warning');
                            });
                        }
                        
                        if (isForced) {
                            resetTimer();
                        }
                    } else {
                        showToast('Simulation Info', data.message || 'Simulation failed.', 'warning');
                    }
                })
                .catch(err => {
                    console.error(err);
                    showToast('Error', 'An error occurred during transaction simulation.', 'warning');
                })
                .finally(() => {
                    isSimulating = false;
                    if (btn) {
                        btn.disabled = false;
                        btn.classList.remove('opacity-75', 'cursor-not-allowed');
                    }
                    if (icon) {
                        icon.classList.remove('animate-spin');
                    }
                });
            }

            function updateStats(stats) {
                const totalSalesEl = document.getElementById('stat-total-sales');
                const todaySalesEl = document.getElementById('stat-today-sales');
                const transactionsEl = document.getElementById('stat-transactions');
                const lowStockEl = document.getElementById('stat-low-stock');
                
                if (totalSalesEl) {
                    flashElement(totalSalesEl);
                    totalSalesEl.innerText = `₱${stats.total_sales}`;
                }
                if (todaySalesEl) {
                    flashElement(todaySalesEl, 'text-green-600');
                    todaySalesEl.innerText = `₱${stats.today_sales}`;
                }
                if (transactionsEl) {
                    flashElement(transactionsEl);
                    transactionsEl.innerText = stats.total_transactions;
                }
                if (lowStockEl) {
                    flashElement(lowStockEl, 'text-red-600');
                    lowStockEl.innerText = stats.low_stock_products;
                }
            }

            function flashElement(el, originalTextClass = 'text-gray-900') {
                el.classList.remove(originalTextClass, 'dark:text-white');
                el.classList.add('text-green-500', 'scale-105');
                
                setTimeout(() => {
                    el.classList.remove('text-green-500', 'scale-105');
                    el.classList.add(originalTextClass, 'dark:text-white');
                }, 1000);
            }

            function addActivityToFeed(data) {
                const itemsString = data.items.map(item => `${item.quantity}x ${item.name}`).join(', ');
                
                const log = {
                    cashier_name: data.cashier_name,
                    timestamp: data.timestamp,
                    total_amount: data.total_amount,
                    items: itemsString
                };
                
                let logs = JSON.parse(localStorage.getItem('demo_activity_logs') || '[]');
                logs.unshift(log);
                if (logs.length > 15) {
                    logs.pop();
                }
                localStorage.setItem('demo_activity_logs', JSON.stringify(logs));
                
                renderFeed();
            }

            function renderFeed() {
                const feed = document.getElementById('demo-activity-feed');
                if (!feed) return;
                
                let logs = JSON.parse(localStorage.getItem('demo_activity_logs') || '[]');
                
                if (logs.length === 0) {
                    feed.innerHTML = `
                        <div class="text-center py-6 text-gray-500 dark:text-gray-400 italic text-xs">
                            No activity yet. Simulator is running...
                        </div>
                    `;
                    return;
                }
                
                feed.innerHTML = logs.map(log => `
                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-100 dark:border-gray-700 flex items-start gap-3 text-sm transition hover:shadow-sm">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 rounded-full shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-baseline mb-1">
                                <span class="font-semibold text-gray-900 dark:text-white truncate text-xs">${escapeHtml(log.cashier_name)}</span>
                                <span class="text-[10px] text-gray-400 whitespace-nowrap">${log.timestamp}</span>
                            </div>
                            <p class="text-[11px] text-gray-600 dark:text-gray-400 leading-tight">
                                Checked out: <span class="font-medium text-gray-800 dark:text-gray-200">${escapeHtml(log.items)}</span>
                            </p>
                            <div class="mt-1 flex items-center justify-between text-xs">
                                <span class="text-green-600 dark:text-green-400 font-bold text-xs">₱${log.total_amount}</span>
                                <span class="text-[9px] bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300 px-1.5 py-0.5 rounded font-medium">SIMULATED</span>
                            </div>
                        </div>
                    </div>
                `).join('');
            }

            function prependToTransactionsTable(data) {
                const tbody = document.getElementById('recent-transactions-tbody');
                if (!tbody) return;
                
                const emptyRow = tbody.querySelector('tr td.italic');
                if (emptyRow) {
                    tbody.innerHTML = '';
                }
                
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50 dark:hover:bg-gray-700 transition bg-green-50/30 dark:bg-green-900/10';
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">Just now</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">${escapeHtml(data.cashier_name)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">₱${data.total_amount}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <span class="text-[10px] bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300 px-2 py-0.5 rounded font-bold uppercase tracking-wider">Simulated</span>
                    </td>
                `;
                
                tbody.insertBefore(row, tbody.firstChild);
                
                if (tbody.children.length > 5) {
                    tbody.removeChild(tbody.lastChild);
                }
            }

            const TOTAL_TIME = 300; // 5 minutes in seconds
            let timeLeft = TOTAL_TIME;
            let timerInterval = null;

            function startTimer() {
                clearInterval(timerInterval);
                timerInterval = setInterval(() => {
                    timeLeft--;
                    updateTimerUI();
                    
                    if (timeLeft <= 0) {
                        triggerSimulation();
                        resetTimer();
                    }
                }, 1000);
            }

            function resetTimer() {
                timeLeft = TOTAL_TIME;
                updateTimerUI();
            }

            function updateTimerUI() {
                const timerText = document.getElementById('demo-timer-text');
                const progressBar = document.getElementById('demo-progress-bar');
                
                if (timerText) {
                    const mins = Math.floor(timeLeft / 60);
                    const secs = timeLeft % 60;
                    timerText.innerText = `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
                }
                
                if (progressBar) {
                    const percent = ((TOTAL_TIME - timeLeft) / TOTAL_TIME) * 100;
                    progressBar.style.width = `${percent}%`;
                }
            }

            document.addEventListener('DOMContentLoaded', () => {
                renderFeed();
                resetTimer();
                startTimer();
                
                const simulateBtn = document.getElementById('simulate-now-btn');
                if (simulateBtn) {
                    simulateBtn.addEventListener('click', () => {
                        triggerSimulation(true);
                    });
                }
                
                const flashSuccess = "{{ session('success') }}";
                if (flashSuccess.includes('reset') || flashSuccess.includes('Welcome')) {
                    localStorage.removeItem('demo_activity_logs');
                    renderFeed();
                }
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    const modal = document.getElementById('add-employee-modal');
                    if (modal && !modal.classList.contains('hidden')) {
                        modal.classList.add('hidden');
                    }
                }
            });
        </script>

        <!-- Add Employee Modal -->
        <div id="add-employee-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 dark:bg-gray-900/80 transition-opacity backdrop-blur-sm" onclick="document.getElementById('add-employee-modal').classList.add('hidden')"></div>

                <!-- Spacer to center modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal Content -->
                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200 dark:border-gray-700">
                    <div class="bg-white dark:bg-gray-800 px-6 pt-6 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-primary-100 dark:bg-primary-900/50 text-primary-600 dark:text-primary-400 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-white" id="modal-title">
                                    Add Demo Cashier
                                </h3>
                                <div class="mt-2">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Create a new demo cashier employee. These credentials can be used to log in when you exit Demo Mode, or they will be used randomly by the simulation engine to generate cashier actions.
                                    </p>
                                </div>

                                <form action="{{ route('demo.addEmployee') }}" method="POST" class="mt-4 space-y-4">
                                    @csrf
                                    <div>
                                        <label for="new_emp_name" class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Full Name</label>
                                        <input type="text" name="name" id="new_emp_name" required class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-650 dark:bg-gray-700 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500 shadow-sm" placeholder="e.g. Juan dela Cruz">
                                    </div>
                                    <div>
                                        <label for="new_emp_email" class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Email Address</label>
                                        <input type="email" name="email" id="new_emp_email" required class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-650 dark:bg-gray-700 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500 shadow-sm" placeholder="e.g. juan@pos.com">
                                    </div>
                                    <div>
                                        <label for="new_emp_password" class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Password</label>
                                        <input type="password" name="password" id="new_emp_password" required minlength="8" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-650 dark:bg-gray-700 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500 shadow-sm" placeholder="At least 8 characters">
                                    </div>
                                    
                                    <div class="pt-4 flex flex-row-reverse gap-3">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-primary-600 hover:bg-primary-700 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:text-sm transition">
                                            Add Cashier
                                        </button>
                                        <button type="button" onclick="document.getElementById('add-employee-modal').classList.add('hidden')" class="w-full inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:text-sm transition">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

        </div>
    </div>
</x-app-layout>
