<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Set New Password</h2>
        <p class="text-gray-600 dark:text-gray-400 text-sm">
            {{ __('Enter your new password to regain access to your account.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 dark:text-gray-300 font-medium text-sm mb-2 block" />
            <x-text-input 
                id="email" 
                class="input-field" 
                type="email" 
                name="email" 
                :value="old('email', $request->email)" 
                placeholder="you@example.com"
                required 
                autofocus 
                autocomplete="username" 
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger-600 text-sm" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('New Password')" class="text-gray-700 dark:text-gray-300 font-medium text-sm mb-2 block" />
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

        <x-primary-button class="w-full justify-center py-3 mt-6">
            {{ __('Reset Password') }}
        </x-primary-button>
    </form>
</x-guest-layout>
