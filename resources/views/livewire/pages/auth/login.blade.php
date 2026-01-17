<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="px-2">
    <div class="mb-10 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-50 dark:bg-indigo-900/20 rounded-3xl mb-4">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">أهلاً بك مجدداً</h2>
        <p class="text-gray-500 dark:text-gray-400 mt-3 font-medium">سجل دخولك لمتابعة أعمالك اليومية</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800 rounded-2xl text-green-600 dark:text-green-400 text-sm font-bold text-center">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="login" class="space-y-7">
        <!-- Email Address -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('البريد الإلكتروني')" class="text-sm font-bold text-gray-700 dark:text-gray-300 mr-1" />
            <div class="relative group">
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none transition-colors group-focus-within:text-indigo-600 text-gray-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input wire:model="form.email" id="email" type="email" required autofocus 
                    class="block w-full pr-12 pl-4 py-4 bg-gray-50 dark:bg-gray-800/50 border-gray-100 dark:border-gray-700 rounded-[1.25rem] focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-gray-900 dark:text-white transition-all duration-300 placeholder-gray-400/70"
                    placeholder="name@company.com" />
            </div>
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-xs font-bold mr-1" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <div class="flex items-center justify-between mr-1 ml-1">
                <x-input-label for="password" :value="__('كلمة المرور')" class="text-sm font-bold text-gray-700 dark:text-gray-300" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-black text-indigo-600 hover:text-indigo-500 transition" href="{{ route('password.request') }}" wire:navigate>
                        {{ __('نسيت كلمة المرور؟') }}
                    </a>
                @endif
            </div>
            <div class="relative group">
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none transition-colors group-focus-within:text-indigo-600 text-gray-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input wire:model="form.password" id="password" type="password" required 
                    class="block w-full pr-12 pl-4 py-4 bg-gray-50 dark:bg-gray-800/50 border-gray-100 dark:border-gray-700 rounded-[1.25rem] focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-gray-900 dark:text-white transition-all duration-300 placeholder-gray-400/70"
                    placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-xs font-bold mr-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center mr-1">
            <div class="flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" 
                    class="w-5 h-5 text-indigo-600 border-gray-200 dark:border-gray-700 rounded-lg focus:ring-indigo-500 dark:bg-gray-800 transition cursor-pointer">
                <label for="remember" class="mr-3 text-sm font-bold text-gray-600 dark:text-gray-400 cursor-pointer select-none">تذكرني على هذا الجهاز</label>
            </div>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl shadow-xl shadow-indigo-500/25 transition-all duration-300 transform hover:-translate-y-1 active:scale-[0.98] flex items-center justify-center gap-2">
                <span>تسجيل الدخول</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
            </button>
        </div>
        
        <div class="text-center mt-10 p-6 bg-gray-50/50 dark:bg-gray-800/30 rounded-3xl border border-gray-100 dark:border-gray-700">
            <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">
                ليس لديك حساب؟
                <a href="{{ route('register') }}" class="font-black text-indigo-600 hover:text-indigo-500 transition ml-1" wire:navigate>أنشئ حساباً جديداً</a>
            </p>
        </div>
    </form>
</div>
