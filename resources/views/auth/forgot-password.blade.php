<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Reset Password</h2>
        <p class="text-gray-600 dark:text-gray-400 text-sm">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6 p-4 rounded-lg bg-success-50 dark:bg-success-900 border border-success-200 dark:border-success-800 text-success-800 dark:text-success-200" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
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
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger-600 text-sm" />
        </div>

        <div class="flex items-center gap-4 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('login') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium transition">
                {{ __('Back to login') }}
            </a>
            <x-primary-button class="ms-auto">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
