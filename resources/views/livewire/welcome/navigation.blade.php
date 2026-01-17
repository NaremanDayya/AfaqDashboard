<nav class="-mx-3 flex flex-1 justify-end gap-2">
    @auth
        <a
            href="{{ url('/dashboard') }}"
            class="rounded-lg px-4 py-2 bg-indigo-600 text-white transition hover:bg-indigo-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500"
        >
            {{ __('messages.dashboard') }}
        </a>
    @else
        <a
            href="{{ route('login') }}"
            class="rounded-lg px-4 py-2 text-gray-700 dark:text-gray-300 transition hover:text-indigo-600 dark:hover:text-indigo-400 focus:outline-none"
        >
            {{ __('تسجيل الدخول') }}
        </a>

        @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="rounded-lg px-4 py-2 bg-indigo-600 text-white transition hover:bg-indigo-700 focus:outline-none"
            >
                {{ __('إنشاء حساب') }}
            </a>
        @endif
    @endauth
</nav>
