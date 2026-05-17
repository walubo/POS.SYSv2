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
            .animated-background{
                position:fixed;
                inset:0;
                background:
                    radial-gradient(circle at top left, rgba(0,110,255,0.15), transparent 30%),
                    radial-gradient(circle at bottom right, rgba(0,80,255,0.15), transparent 35%),
                    linear-gradient(135deg,#020817,#071427,#020817);
                overflow:hidden;
                z-index:-1;
            }

            /* GLOWING WAVES */
            .bg-wave{
                position:absolute;
                width:160%;
                height:300px;
                border-radius:50%;
                filter:blur(2px);
                opacity:0.9;
            }

            /* TOP WAVE */
            .wave-top{
                top:-50px;
                left:-20%;
                border-top:2px solid #1d7dff;
                animation:waveTop 12s ease-in-out infinite alternate;
            }

            /* BOTTOM WAVE */
            .wave-bottom{
                bottom:-100px;
                left:-10%;
                border-top:3px solid #005eff;
                animation:waveBottom 14s ease-in-out infinite alternate;
            }

            /* SECONDARY SOFT WAVES */
            .wave-soft{
                position:absolute;
                width:180%;
                height:350px;
                border-radius:50%;
                border-top:1px solid rgba(0,140,255,0.15);
                filter:blur(1px);
            }

            .soft1{ top:-120px; left:-25%; animation:softMove1 18s ease-in-out infinite alternate; }
            .soft2{ bottom:-150px; left:-30%; animation:softMove2 20s ease-in-out infinite alternate; }

            /* FLOWING GLOW */
            .bg-glow{
                position:absolute;
                width:500px;
                height:500px;
                border-radius:50%;
                background:radial-gradient(circle,#006eff55,transparent 70%);
                filter:blur(40px);
            }

            .glow1{ top:-100px; left:-100px; animation:floatGlow1 16s ease-in-out infinite alternate; }
            .glow2{ bottom:-120px; right:-100px; animation:floatGlow2 18s ease-in-out infinite alternate; }

            /* DOTS */
            .bg-dots{
                position:absolute;
                width:180px;
                height:180px;
                background-image:radial-gradient(#1da1ff 1.5px, transparent 1.5px);
                background-size:18px 18px;
                opacity:0.35;
            }

            .dots1{ top:30px; left:30px; animation:fadeDots 5s infinite alternate; }
            .dots2{ bottom:40px; right:40px; animation:fadeDots 6s infinite alternate; }

            /* ANIMATIONS */
            @keyframes waveTop{
                0%{ transform:translateX(0px) translateY(0px); }
                50%{ transform:translateX(30px) translateY(10px); }
                100%{ transform:translateX(-20px) translateY(-10px); }
            }

            @keyframes waveBottom{
                0%{ transform:translateX(0px) translateY(0px); }
                50%{ transform:translateX(-40px) translateY(-10px); }
                100%{ transform:translateX(20px) translateY(15px); }
            }

            @keyframes softMove1{
                0%{ transform:translateX(0px); }
                100%{ transform:translateX(-40px); }
            }

            @keyframes softMove2{
                0%{ transform:translateX(0px); }
                100%{ transform:translateX(50px); }
            }

            @keyframes floatGlow1{
                0%{ transform:translate(0,0); }
                100%{ transform:translate(80px,40px); }
            }

            @keyframes floatGlow2{
                0%{ transform:translate(0,0); }
                100%{ transform:translate(-60px,-30px); }
            }

            @keyframes fadeDots{
                0%{ opacity:0.15; }
                100%{ opacity:0.4; }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 dark:text-gray-100 antialiased">
        <div class="animated-background">
            <!-- GLOW -->
            <div class="bg-glow glow1"></div>
            <div class="bg-glow glow2"></div>

            <!-- WAVES -->
            <div class="bg-wave wave-top"></div>
            <div class="bg-wave wave-bottom"></div>

            <!-- SOFT WAVES -->
            <div class="wave-soft soft1"></div>
            <div class="wave-soft soft2"></div>

            <!-- DOTS -->
            <div class="bg-dots dots1"></div>
            <div class="bg-dots dots2"></div>
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
