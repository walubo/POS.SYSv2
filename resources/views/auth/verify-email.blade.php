<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Verify Email Address</h2>
        <p class="text-gray-600 dark:text-gray-400 text-sm">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 rounded-lg bg-success-50 dark:bg-success-900 border border-success-200 dark:border-success-800 text-success-800 dark:text-success-200 text-sm font-medium">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <form method="POST" action="{{ route('verification.send') }}" class="flex-1 sm:flex-none">
            @csrf
            <x-primary-button class="w-full sm:w-auto">
                {{ __('Resend Verification Email') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="flex-1 sm:flex-none">
            @csrf
            <button type="submit" class="w-full sm:w-auto px-4 py-2 text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900 transition">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
