<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // Default role is developer
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $validated['password'],
            'role' => 'developer',
        ]);

        event(new Registered($user));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="px-2">
    <div class="mb-10 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-50 dark:bg-indigo-900/20 rounded-3xl mb-4">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
        </div>
        <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">حساب جديد</h2>
        <p class="text-gray-500 dark:text-gray-400 mt-3 font-medium">انضم إلينا وابدأ بتنظيم أعمالك اليوم</p>
    </div>

    <form wire:submit="register" class="space-y-6">
        <!-- Name -->
        <div class="space-y-2">
            <x-input-label for="name" :value="__('الاسم الكامل')" class="text-sm font-bold text-gray-700 dark:text-gray-300 mr-1" />
            <div class="relative group">
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none transition-colors group-focus-within:text-indigo-600 text-gray-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
                <input wire:model="name" id="name" type="text" required autofocus 
                    class="block w-full pr-12 pl-4 py-4 bg-gray-50 dark:bg-gray-800/50 border-gray-100 dark:border-gray-700 rounded-[1.25rem] focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-gray-900 dark:text-white transition-all duration-300 placeholder-gray-400/70"
                    placeholder="اسمك الثلاثي" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs font-bold mr-1" />
        </div>

        <!-- Email Address -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('البريد الإلكتروني')" class="text-sm font-bold text-gray-700 dark:text-gray-300 mr-1" />
            <div class="relative group">
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none transition-colors group-focus-within:text-indigo-600 text-gray-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                </div>
                <input wire:model="email" id="email" type="email" required 
                    class="block w-full pr-12 pl-4 py-4 bg-gray-50 dark:bg-gray-800/50 border-gray-100 dark:border-gray-700 rounded-[1.25rem] focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-gray-900 dark:text-white transition-all duration-300 placeholder-gray-400/70"
                    placeholder="name@company.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-bold mr-1" />
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <!-- Password -->
            <div class="space-y-2 font-bold">
                <x-input-label for="password" :value="__('كلمة المرور')" class="text-xs font-bold text-gray-700 dark:text-gray-300 mr-1" />
                <div class="relative group">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none transition-colors group-focus-within:text-indigo-600 text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                    <input wire:model="password" id="password" type="password" required 
                        class="block w-full pr-10 pl-3 py-3.5 bg-gray-50 dark:bg-gray-800/50 border-gray-100 dark:border-gray-700 rounded-[1.125rem] focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm"
                        placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-bold mr-1" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <x-input-label for="password_confirmation" :value="__('تأكيد المرور')" class="text-xs font-bold text-gray-700 dark:text-gray-300 mr-1" />
                <div class="relative group">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none transition-colors group-focus-within:text-indigo-600 text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    </div>
                    <input wire:model="password_confirmation" id="password_confirmation" type="password" required 
                        class="block w-full pr-10 pl-3 py-3.5 bg-gray-50 dark:bg-gray-800/50 border-gray-100 dark:border-gray-700 rounded-[1.125rem] focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm"
                        placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs font-bold mr-1" />
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl shadow-xl shadow-indigo-500/25 transition-all duration-300 transform hover:-translate-y-1 active:scale-[0.98] flex items-center justify-center gap-2">
                <span>إنشاء حساب جديد</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3" />
                </svg>
            </button>
        </div>
        
        <div class="text-center mt-8 p-6 bg-gray-50/50 dark:bg-gray-800/30 rounded-3xl border border-gray-100 dark:border-gray-700">
            <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">
                لديك حساب بالفعل؟
                <a href="{{ route('login') }}" class="font-black text-indigo-600 hover:text-indigo-500 transition ml-1" wire:navigate>تسجيل الدخول</a>
            </p>
        </div>
    </form>
</div>
