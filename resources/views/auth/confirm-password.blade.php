<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Confirm Password</h2>
        <p class="text-gray-600 dark:text-gray-400 text-sm">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 dark:text-gray-300 font-medium text-sm mb-2 block" />
            <x-text-input 
                id="password" 
                class="input-field"
                type="password"
                name="password"
                placeholder="••••••••"
                required 
                autocomplete="current-password" 
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger-600 text-sm" />
        </div>

        <x-primary-button class="w-full justify-center py-3 mt-6">
            {{ __('Confirm') }}
        </x-primary-button>
    </form>
</x-guest-layout>
