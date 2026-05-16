<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Create Account</h2>
        <p class="text-gray-600 dark:text-gray-400 text-sm">Sign up to get started with RetailFlow</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" class="text-gray-700 dark:text-gray-300 font-medium text-sm mb-2 block" />
            <x-text-input 
                id="name" 
                class="input-field" 
                type="text" 
                name="name" 
                :value="old('name')" 
                placeholder="John Doe"
                required 
                autofocus 
                autocomplete="name" 
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger-600 text-sm" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 dark:text-gray-300 font-medium text-sm mb-2 block" />
            <x-text-input 
                id="email" 
                class="input-field" 
                type="email" 
                name="email" 
                :value="old('email')" 
                placeholder="you@example.com"
                required 
                autocomplete="username" 
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger-600 text-sm" />
        </div>

        <!-- Role -->
        <div>
            <x-input-label for="role" :value="__('Account Type')" class="text-gray-700 dark:text-gray-300 font-medium text-sm mb-2 block" />
            <select id="role" name="role" class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring-primary-500 rounded-lg shadow-sm" required>
                <option value="admin">Admin</option>
                <option value="cashier" selected>Employee (Cashier)</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2 text-danger-600 text-sm" />
        </div>

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
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger-600 text-sm" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 dark:text-gray-300 font-medium text-sm mb-2 block" />
            <x-text-input 
                id="password_confirmation" 
                class="input-field"
                type="password"
                name="password_confirmation" 
                placeholder="••••••••"
                required 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger-600 text-sm" />
        </div>

        <!-- Register Button -->
        <x-primary-button class="w-full justify-center py-3 mt-6">
            {{ __('Create Account') }}
        </x-primary-button>

        <!-- Login Link -->
        <div class="text-center text-sm text-gray-600 dark:text-gray-400 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <span>Already have an account? </span>
            <a href="{{ route('login') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-semibold transition">
                Sign in here
            </a>
        </div>
    </form>
</x-guest-layout>
