<?php

use App\Models\Project;
use Livewire\Volt\Component;

new class extends Component
{
    public $name = '';
    public $description = '';
    public $showModal = false;

    public function mount()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'غير مصرح لك بالوصول لهذه الصفحة.');
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Project::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->reset(['name', 'description', 'showModal']);
        $this->dispatch('project-added');
    }

    public function delete($id)
    {
        Project::find($id)->delete();
    }

    public function with()
    {
        return [
            'projects' => Project::latest()->get(),
        ];
    }
}; ?>

<div class="space-y-6">
    <div class="flex justify-between items-center bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div>
            <h2 class="text-2xl font-black text-gray-900 dark:text-white">إدارة المشاريع</h2>
            <p class="text-sm text-gray-500 mt-1">عرض وإضافة المشاريع الحالية في النظام</p>
        </div>
        <button wire:click="$set('showModal', true)" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-indigo-500/20 transition transform hover:-translate-y-0.5 active:scale-95 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            إضافة مشروع جديد
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($projects as $project)
            <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md transition group h-full flex flex-col">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl flex items-center justify-center text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
                    </div>
                    <button wire:click="delete({{ $project->id }})" wire:confirm="هل أنت متأكد من حذف هذا المشروع؟" class="text-gray-400 hover:text-red-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ $project->name }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 flex-grow">{{ $project->description ?: 'لا يوجد وصف لهذا المشروع.' }}</p>
                <div class="mt-6 pt-6 border-t border-gray-50 dark:border-gray-700 flex justify-between items-center">
                    <span class="text-xs font-bold text-gray-400">تاريخ البدء: {{ $project?->created_at?->format('Y/m/d') }}</span>
                    <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-full text-[10px] font-black uppercase tracking-wider">نشط</span>
                </div>
            </div>
        @endforeach
    </div>

    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" wire:click="$set('showModal', false)"></div>
            <div class="relative bg-white dark:bg-gray-900 w-full max-w-lg rounded-3xl shadow-2xl p-8 transform transition-all">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white">مشروع جديد</h3>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 mr-1">اسم المشروع</label>
                        <input type="text" wire:model="name" class="block w-full px-5 py-4 bg-gray-50 dark:bg-gray-800 border-gray-100 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm font-bold transition" placeholder="مثلاً: تطبيق آفاق">
                        @error('name') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 mr-1">وصف المشروع</label>
                        <textarea wire:model="description" rows="4" class="block w-full px-5 py-4 bg-gray-50 dark:bg-gray-800 border-gray-100 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm transition" placeholder="اكتب نبذة بسيطة عن المشروع..."></textarea>
                        @error('description') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl shadow-xl shadow-indigo-500/20 transition active:scale-[0.98]">
                            إنشاء المشروع
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
