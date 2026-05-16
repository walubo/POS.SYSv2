<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-center p-8">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Welcome, Admin</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-8">You need to create your POS Environment to start selling products and adding employees.</p>
                
                <form action="{{ route('environment.store') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition transform hover:-translate-y-1 text-lg">
                        Create My POS Environment
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
