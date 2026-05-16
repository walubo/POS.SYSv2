<x-app-layout>
    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Join POS Environment</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Enter the 6-digit code provided by your administrator.</p>
                </div>

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <form action="{{ route('environment.processJoin') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="join_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">6-Digit Code</label>
                        <input type="text" name="join_code" id="join_code" maxlength="6" class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md text-center tracking-[0.5em] uppercase" placeholder="XXXXXX" required>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Join System
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
