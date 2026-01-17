<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Daily Work Log') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body {
                font-family: 'Cairo', sans-serif;
            }
            .hero-gradient {
                background: radial-gradient(circle at 50% 50%, rgba(79, 70, 229, 0.1) 0%, transparent 50%);
            }
        </style>
    </head>
    <body class="antialiased bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 overflow-x-hidden">
        <div class="relative min-h-screen flex flex-col">
            <!-- Background Decoration -->
            <div class="absolute inset-0 hero-gradient pointer-events-none"></div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl"></div>

            <header class="container mx-auto px-6 py-8 flex justify-between items-center relative z-10">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <span class="text-2xl font-black tracking-tight text-gray-900 dark:text-white">آفاق <span class="text-indigo-600">داشبورد</span></span>
                </div>

                @if (Route::has('login'))
                    <livewire:welcome.navigation />
                @endif
            </header>

            <main class="flex-grow flex items-center relative z-10">
                <div class="container mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center py-12">
                    <div class="space-y-8 text-right">
                        <div class="inline-block px-4 py-1.5 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-full text-sm font-bold tracking-wide uppercase">
                            نظام تتبع العمل اليومي
                        </div>
                        <h1 class="text-5xl lg:text-7xl font-black text-gray-900 dark:text-white leading-tight">
                            وداعاً للمتابعة <br/>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">المجهدة والمباشرة</span>
                        </h1>
                        <p class="text-xl text-gray-600 dark:text-gray-400 max-w-xl leading-relaxed">
                            سجل مهامك اليومية بكل سهولة، وشارك تقدمك مع فريق الإدارة بكل شفافية واحترافية. نظام بسيط، ذكي، وفعال.
                        </p>
                        <div class="flex flex-wrap gap-4 justify-end lg:justify-start">
                            <a href="{{ route('login') }}" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold shadow-xl shadow-indigo-500/25 transition transform hover:-translate-y-1">
                                ابدأ الآن مجاناً
                            </a>
                            <a href="#features" class="px-8 py-4 bg-white dark:bg-gray-800 border-2 border-gray-100 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded-2xl font-bold transition hover:border-indigo-600">
                                تعرّف على المزيد
                            </a>
                        </div>
                    </div>
                    <div class="relative hidden lg:block">
                        <div class="absolute -inset-4 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-3xl blur opacity-20 animate-pulse"></div>
                        <div class="relative bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl shadow-2xl p-4">
                            <!-- Simple UI Mockup -->
                            <div class="bg-gray-50 dark:bg-gray-950 p-6 rounded-2xl space-y-4">
                                <div class="flex justify-between items-center border-b border-gray-100 dark:border-gray-800 pb-4">
                                    <div class="flex gap-2">
                                        <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                        <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                        <div class="w-3 h-3 rounded-full bg-green-400"></div>
                                    </div>
                                    <div class="text-xs font-bold opacity-50">Work Log Dashboard</div>
                                </div>
                                <div class="space-y-3">
                                    <div class="h-12 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 flex items-center px-4 justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-5 h-5 rounded-full bg-green-500"></div>
                                            <div class="text-sm">تطوير واجهة المستخدم</div>
                                        </div>
                                        <div class="text-xs opacity-50">4 ساعات</div>
                                    </div>
                                    <div class="h-12 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 flex items-center px-4 justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-5 h-5 rounded-full bg-blue-500"></div>
                                            <div class="text-sm">اجتماع الفريق التقني</div>
                                        </div>
                                        <div class="text-xs opacity-50">1.5 ساعة</div>
                                    </div>
                                    <div class="h-32 bg-indigo-600 rounded-xl shadow-lg p-4 text-white">
                                        <div class="text-xs opacity-80">إحصائيات اليوم</div>
                                        <div class="text-2xl font-bold mt-2">8.5 ساعة</div>
                                        <div class="text-xs mt-1">إنجاز رائع اليوم! 🚀</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="container mx-auto px-6 py-12 text-center text-gray-500 dark:text-gray-600 border-t border-gray-100 dark:border-gray-900">
                <p>&copy; {{ date('Y') }} آفاق داشبورد. جميع الحقوق محفوظة.</p>
            </footer>
        </div>
    </body>
</html>
