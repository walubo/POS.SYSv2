<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Core POS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        <div class="min-h-screen">
            @if(session('demo_mode'))
                <div class="bg-gradient-to-r from-amber-500 via-orange-600 to-amber-500 text-white shadow-md relative overflow-hidden">
                    <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center space-x-3">
                            <span class="flex h-3 w-3 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                            </span>
                            <p class="font-medium text-sm sm:text-base">
                                <span class="font-bold">Demo Mode Active:</span> You are exploring the POS simulation environment. Real database is unaffected.
                            </p>
                        </div>
                        <div class="flex items-center space-x-3 shrink-0">
                            <a href="{{ route('demo.reset') }}" class="bg-white/10 hover:bg-white/20 text-white text-xs font-semibold px-3 py-1.5 rounded-lg border border-white/20 transition shadow-sm hover:shadow" onclick="return confirm('Are you sure you want to reset all demo data? This will clear all transactions and restore the default products.')">
                                Reset Demo
                            </a>
                            <a href="{{ route('demo.leave') }}" class="bg-white text-orange-700 hover:bg-orange-50 text-xs font-bold px-4 py-1.5 rounded-lg transition shadow-sm hover:shadow-md">
                                Exit Demo Mode
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
