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

        <style>
            /* MAIN BACKGROUND */
            .animated-background {
                position:fixed;
                inset:0;
                background:
                    radial-gradient(circle at top left, rgba(0,140,255,0.15), transparent 30%),
                    radial-gradient(circle at bottom right, rgba(0,90,255,0.18), transparent 35%),
                    linear-gradient(135deg,#020817,#071427,#020817);
                overflow:hidden;
                z-index:-1;
            }

            /* SMOOTH FLOWING BLOBS */
            .bg-blob{
                position:absolute;
                border-radius:50%;
                filter:blur(80px);
                opacity:0.5;
                animation-timing-function:ease-in-out;
                animation-iteration-count:infinite;
            }

            .blob1{
                width:500px;
                height:500px;
                background:#0066ff;
                top:-120px;
                left:-120px;
                animation:float1 18s infinite alternate;
            }

            .blob2{
                width:450px;
                height:450px;
                background:#00aaff;
                bottom:-100px;
                right:-120px;
                animation:float2 22s infinite alternate;
            }

            .blob3{
                width:300px;
                height:300px;
                background:#0044ff;
                top:40%;
                left:50%;
                transform:translate(-50%,-50%);
                opacity:0.25;
                animation:pulse 12s infinite ease-in-out;
            }

            /* FLOWING LIGHT WAVES */
            .bg-wave{
                position:absolute;
                width:200%;
                height:200px;
                border-radius:40%;
                opacity:0.08;
                filter:blur(10px);
                background:linear-gradient(90deg, transparent, #1da1ff, transparent);
            }

            .wave1{ top:20%; left:-50%; animation:waveMove 20s linear infinite; }
            .wave2{ bottom:15%; left:-50%; animation:waveMoveReverse 26s linear infinite; }

            /* FLOATING PARTICLES */
            .bg-particle{
                position:absolute;
                width:4px;
                height:4px;
                border-radius:50%;
                background:#4db8ff;
                opacity:0.4;
                animation:particleFloat linear infinite;
            }

            .p1{ left:10%; animation-duration:14s; animation-delay:0s; }
            .p2{ left:25%; animation-duration:18s; animation-delay:2s; }
            .p3{ left:40%; animation-duration:16s; animation-delay:1s; }
            .p4{ left:60%; animation-duration:20s; animation-delay:3s; }
            .p5{ left:75%; animation-duration:15s; animation-delay:1s; }
            .p6{ left:90%; animation-duration:19s; animation-delay:4s; }

            /* ANIMATIONS */
            @keyframes float1{
                0%{ transform:translate(0,0) scale(1); }
                100%{ transform:translate(120px,80px) scale(1.15); }
            }

            @keyframes float2{
                0%{ transform:translate(0,0) scale(1); }
                100%{ transform:translate(-100px,-60px) scale(1.1); }
            }

            @keyframes pulse{
                0%,100%{ transform:translate(-50%,-50%) scale(1); }
                50%{ transform:translate(-50%,-50%) scale(1.2); }
            }

            @keyframes waveMove{
                0%{ transform:translateX(0); }
                100%{ transform:translateX(-25%); }
            }

            @keyframes waveMoveReverse{
                0%{ transform:translateX(-25%); }
                100%{ transform:translateX(0); }
            }

            @keyframes particleFloat{
                0%{ transform:translateY(100vh) scale(0); opacity:0; }
                10%{ opacity:0.4; }
                100%{ transform:translateY(-10vh) scale(1); opacity:0; }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 dark:text-gray-100 antialiased">
        <div class="animated-background">
            <!-- BLOBS -->
            <div class="bg-blob blob1"></div>
            <div class="bg-blob blob2"></div>
            <div class="bg-blob blob3"></div>

            <!-- WAVES -->
            <div class="bg-wave wave1"></div>
            <div class="bg-wave wave2"></div>

            <!-- PARTICLES -->
            <div class="bg-particle p1"></div>
            <div class="bg-particle p2"></div>
            <div class="bg-particle p3"></div>
            <div class="bg-particle p4"></div>
            <div class="bg-particle p5"></div>
            <div class="bg-particle p6"></div>
        </div>

        <div class="min-h-screen flex flex-col justify-center items-center px-4 relative z-10">
            <!-- Logo Section -->
            <div class="mb-8">
                <a href="/" class="flex justify-center">
                    <x-application-logo class="w-auto h-12" />
                </a>
            </div>

            <!-- Auth Card -->
            <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-8 py-8">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer Text -->
            <div class="mt-8 text-center text-sm text-gray-600 dark:text-gray-400">
                <p>&copy; {{ date('Y') }} Core POS. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>
