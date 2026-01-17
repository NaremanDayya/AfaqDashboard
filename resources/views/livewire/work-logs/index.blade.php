<?php

use App\Models\DailyLog;
use App\Models\Project;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public $projects;
    public $date;
    public $project_id;
    public $title;
    public $description;
    public $hours;
    public $status = 'done';

    public function mount()
    {
        $this->projects = Project::all();
        $this->date = now()->format('Y-m-d');
    }

    public function save()
    {
        $this->validate([
            'project_id' => 'required|exists:projects,id',
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'hours' => 'required|numeric|min:0.5',
            'status' => 'required|in:done,in_progress,blocked',
        ]);

        DailyLog::create([
            'user_id' => Auth::id(),
            'project_id' => $this->project_id,
            'date' => $this->date,
            'title' => $this->title,
            'description' => $this->description,
            'hours' => $this->hours,
            'status' => $this->status,
        ]);

        $this->reset(['project_id', 'title', 'description', 'hours', 'status']);
        $this->dispatch('log-added');
    }

    public function with()
    {
        return [
            'logs' => DailyLog::where('user_id', Auth::id())
                ->where('date', $this->date)
                ->with('project', 'comments.admin')
                ->latest()
                ->get(),
        ];
    }
}; ?>

<div class="space-y-10 pb-20">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white dark:bg-gray-800 p-8 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-700">
        <div>
            <h2 class="text-3xl font-black text-gray-900 dark:text-white">سجل العمل اليومي</h2>
            <p class="text-gray-500 mt-2 font-medium">مرحباً بك، {{ auth()->user()->name }}. كيف كان يومك؟</p>
        </div>
        <div class="flex items-center gap-3 bg-gray-50 dark:bg-gray-900 p-2 rounded-2xl border border-gray-100 dark:border-gray-700">
            <span class="text-sm font-bold text-gray-400 px-3">التاريخ:</span>
            <input type="date" wire:model.live="date" class="bg-transparent border-none focus:ring-0 text-sm font-bold text-indigo-600">
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-10">
        <!-- Input Form Card -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-[2.5rem] shadow-xl shadow-indigo-500/5 border border-gray-100 dark:border-gray-700 sticky top-10">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 dark:text-white">إضافة مهام اليوم</h3>
                </div>

                <form wire:submit="save" class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">المشروع</label>
                        <select wire:model="project_id" class="block w-full px-5 py-4 bg-gray-50 dark:bg-gray-900 border-gray-100 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm font-bold transition">
                            <option value="">اختر المشروع...</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                        @error('project_id') <span class="text-red-500 text-[10px] mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">عنوان المهمة</label>
                        <input type="text" wire:model="title" placeholder="ماذا فعلت؟" class="block w-full px-5 py-4 bg-gray-50 dark:bg-gray-900 border-gray-100 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm font-bold transition">
                        @error('title') <span class="text-red-500 text-[10px] mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">الوصف التفصيلي</label>
                        <textarea wire:model="description" rows="4" class="block w-full px-5 py-4 bg-gray-50 dark:bg-gray-900 border-gray-100 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm transition"></textarea>
                        @error('description') <span class="text-red-500 text-[10px] mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">الساعات</label>
                            <input type="number" step="0.5" wire:model="hours" class="block w-full px-5 py-4 bg-gray-50 dark:bg-gray-900 border-gray-100 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm font-black transition">
                            @error('hours') <span class="text-red-500 text-[10px] mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">الحالة</label>
                            <select wire:model="status" class="block w-full px-5 py-4 bg-gray-50 dark:bg-gray-900 border-gray-100 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm font-bold transition">
                                <option value="done">تم الإنجاز</option>
                                <option value="in_progress">قيد العمل</option>
                                <option value="blocked">متوقف</option>
                            </select>
                            @error('status') <span class="text-red-500 text-[10px] mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl shadow-xl shadow-indigo-500/25 transition transform active:scale-95 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        حفظ المهمة
                    </button>
                </form>
            </div>
        </div>

        <!-- Logs View Card -->
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-black text-gray-900 dark:text-white">ملخص إنجازاتك اليوم</h3>
                <span class="px-4 py-2 bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 rounded-2xl text-xs font-black uppercase tracking-widest">
                    {{ $logs->sum('hours') }} ساعة إجمالاً
                </span>
            </div>

            <div class="grid gap-6">
                @forelse($logs as $log)
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 shadow-sm relative group overflow-hidden">
                        <div class="absolute top-0 right-0 w-1 h-full @if($log->status == 'done') bg-green-500 @elseif($log->status == 'in_progress') bg-blue-500 @else bg-red-500 @endif"></div>
                        
                        <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                            <div class="flex-grow">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-[10px] font-black uppercase tracking-widest px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-md">
                                        {{ $log->project->name }}
                                    </span>
                                    <span class="text-xs font-bold text-gray-400">
                                        {{ $log->created_at->format('h:i A') }}
                                    </span>
                                </div>
                                <h4 class="text-xl font-black text-gray-900 dark:text-white mb-2">{{ $log->title }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">{{ $log->description }}</p>
                            </div>
                            
                            <div class="flex flex-row md:flex-col items-center md:items-end justify-between md:justify-start gap-4 shrink-0">
                                <div class="px-4 py-2 @if($log->status == 'done') bg-green-50 text-green-600 @elseif($log->status == 'in_progress') bg-blue-50 text-blue-600 @else bg-red-50 text-red-600 @endif rounded-2xl text-xs font-black">
                                    {{ __('messages.' . $log->status) }}
                                </div>
                                <div class="text-2xl font-black text-gray-900 dark:text-white">
                                    {{ (float)$log->hours }} <span class="text-[10px] text-gray-400 font-bold">ساعة</span>
                                </div>
                            </div>
                        </div>

                        <!-- Admin Comments section -->
                        @if($log->comments->count() > 0)
                            <div class="mt-8 pt-6 border-t border-gray-50 dark:border-gray-700">
                                <div class="flex items-center gap-2 mb-4">
                                    <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" /></svg>
                                    <h5 class="text-xs font-black text-amber-600 uppercase tracking-widest">ملاحظات الإدارة</h5>
                                </div>
                                <div class="space-y-3">
                                    @foreach($log->comments as $comment)
                                        <div class="bg-amber-50/50 dark:bg-amber-900/10 p-4 rounded-2xl border border-amber-100 dark:border-amber-900/20">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="text-[10px] font-black text-amber-700 dark:text-amber-500">{{ $comment->admin->name }}</span>
                                                <span class="text-[8px] text-amber-400 font-bold">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $comment->comment }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="bg-gray-50 dark:bg-gray-900/50 p-12 rounded-[2.5rem] border-2 border-dashed border-gray-200 dark:border-gray-800 text-center">
                        <div class="w-16 h-16 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h4 class="text-gray-400 font-bold">لا توجد مهام مسجلة لهذا اليوم.</h4>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
