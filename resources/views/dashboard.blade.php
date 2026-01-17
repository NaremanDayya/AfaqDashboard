<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ Auth::user()->isAdmin() ? __('messages.admin_dashboard') : __('messages.daily_logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(Auth::user()->isAdmin())
                <livewire:admin.dashboard />
            @else
                <livewire:work-logs.index />
            @endif
        </div>
    </div>
</x-app-layout>
