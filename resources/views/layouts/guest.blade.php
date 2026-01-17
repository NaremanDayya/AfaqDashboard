<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'آفاق داشبورد') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body {
                font-family: 'Cairo', sans-serif;
            }
            .premium-bg {
                background: radial-gradient(circle at 50% 50%, rgba(79, 70, 229, 0.05) 0%, transparent 50%),
                            radial-gradient(circle at 0% 0%, rgba(99, 102, 241, 0.05) 0%, transparent 50%),
                            radial-gradient(circle at 100% 100%, rgba(168, 85, 247, 0.05) 0%, transparent 50%);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50 dark:bg-gray-950 premium-bg min-h-screen">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-8">
                <a href="/" wire:navigate class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-indigo-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <span class="text-3xl font-black tracking-tight text-gray-900 dark:text-white">آفاق <span class="text-indigo-600">داشبورد</span></span>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-2xl shadow-indigo-100/20 dark:shadow-none sm:rounded-3xl relative overflow-hidden">
                <!-- Decorative element -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/5 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-sm text-gray-500 text-center">
                &copy; {{ date('Y') }} آفاق داشبورد. جميع الحقوق محفوظة.
            </div>
        </div>
    </body>
</html>
