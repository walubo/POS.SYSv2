<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6 p-4 rounded-lg bg-primary-50 dark:bg-primary-900 border border-primary-200 dark:border-primary-800 text-primary-800 dark:text-primary-200" :status="session('status')" />

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Welcome Back</h2>
        <p class="text-gray-600 dark:text-gray-400 text-sm">Sign in to your Core POS account to continue</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

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
                autofocus 
                autocomplete="username" 
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger-600 text-sm" />
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
                autocomplete="current-password" 
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger-600 text-sm" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-primary-600 dark:text-primary-500 bg-white dark:bg-gray-700 cursor-pointer" 
                    name="remember"
                >
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-300 transition">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium transition" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <x-primary-button class="w-full justify-center py-3 mt-6">
            {{ __('Sign In') }}
        </x-primary-button>

        <!-- Sign Up Link -->
        <div class="text-center text-sm text-gray-600 dark:text-gray-400 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <span>Don't have an account? </span>
            <a href="{{ route('register') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-semibold transition">
                Sign up here
            </a>
        </div>
    </form>
</x-guest-layout>
