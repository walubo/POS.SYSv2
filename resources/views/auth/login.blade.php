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

    <!-- Demo Mode Section -->
    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
        <div class="relative overflow-hidden rounded-xl border border-primary-100 dark:border-primary-900 bg-gradient-to-br from-primary-50/50 to-indigo-50/30 dark:from-primary-950/20 dark:to-indigo-950/10 p-5 shadow-sm">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 bg-primary-100 dark:bg-primary-900 p-2 rounded-lg text-primary-600 dark:text-primary-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white">Quick Demo Mode</h4>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">
                        Instantly test all POS features with pre-loaded Philippine-centric products, automatic tenant configuration, and real-time transaction simulation.
                    </p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('demo.enter') }}" class="w-full flex items-center justify-center py-2.5 px-4 rounded-lg bg-gradient-to-r from-primary-600 to-indigo-600 hover:from-primary-700 hover:to-indigo-700 text-white font-bold text-sm shadow hover:shadow-md transition duration-200 transform hover:-translate-y-0.5">
                    Launch Interactive Demo
                    <svg class="w-4 h-4 ms-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
