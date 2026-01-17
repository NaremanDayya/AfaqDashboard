<?php

use App\Models\DailyLog;
use App\Models\Project;
use App\Models\Comment;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public $date;
    public $selectedProject = '';
    public $commentTexts = [];

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
    }

    public function addComment($logId)
    {
        $this->validate([
            'commentTexts.' . $logId => 'required|string|min:3',
        ], [
            'commentTexts.' . $logId . '.required' => 'التعليق مطلوب',
        ]);

        Comment::create([
            'daily_log_id' => $logId,
            'admin_id' => Auth::id(),
            'comment' => $this->commentTexts[$logId],
        ]);

        $this->commentTexts[$logId] = '';
    }

    public function with()
    {
        $query = DailyLog::with(['user', 'project', 'comments.admin'])
            ->where('date', $this->date);

        if ($this->selectedProject) {
            $query->where('project_id', $this->selectedProject);
        }

        $logs = $query->latest()->get();

        return [
            'logs' => $logs,
            'projects' => Project::all(),
            'totalHours' => $logs->sum('hours'),
            'completedCount' => $logs->where('status', 'done')->count(),
            'uniqueDevelopers' => $logs->pluck('user_id')->unique()->count(),
        ];
    }
}; ?>

<div class="space-y-10 pb-20">
    <!-- Header & Statistics Grid -->
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-3xl font-black text-gray-900 dark:text-white">لوحة تحكم الإدارة</h2>
                <p class="text-gray-500 mt-2 font-medium">مراقبة تقدم الفريق والمشاريع لليوم</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-2 px-3 border-l border-gray-100 dark:border-gray-700">
                    <span class="text-xs font-black text-gray-400">التاريخ:</span>
                    <input type="date" wire:model.live="date" class="bg-transparent border-none focus:ring-0 text-sm font-bold text-indigo-600">
                </div>
                <div class="flex items-center gap-2 px-3">
                    <span class="text-xs font-black text-gray-400">المشروع:</span>
                    <select wire:model.live="selectedProject" class="bg-transparent border-none focus:ring-0 text-sm font-bold text-indigo-600">
                        <option value="">كل المشاريع</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Stat Card 1 -->
            <div class="bg-indigo-600 p-8 rounded-[2.5rem] shadow-xl shadow-indigo-500/20 text-white relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition duration-500"></div>
                <h3 class="text-xs font-black opacity-70 uppercase tracking-widest mb-4">إجمالي الساعات المسجلة</h3>
                <div class="flex items-end gap-2">
                    <div class="text-5xl font-black">{{ (float)$totalHours }}</div>
                    <div class="text-sm font-bold mb-1 opacity-70">ساعة عمل</div>
                </div>
            </div>
            
            <!-- Stat Card 2 -->
            <div class="bg-white dark:bg-gray-800 p-8 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4 italic">المهام المكتملة</h3>
                <div class="flex items-end gap-2 text-green-500">
                    <div class="text-5xl font-black">{{ $completedCount }}</div>
                    <div class="text-sm font-bold mb-1 opacity-70">مهمة منجزة</div>
                </div>
            </div>

            <!-- Stat Card 3 -->
            <div class="bg-white dark:bg-gray-800 p-8 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">المطورين النشطين</h3>
                <div class="flex items-end gap-2 text-indigo-600">
                    <div class="text-5xl font-black">{{ $uniqueDevelopers }}</div>
                    <div class="text-sm font-bold mb-1 opacity-70">موظف مسجل اليوم</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logs Table/List -->
    <div class="space-y-6">
        <h3 class="text-xl font-black text-gray-900 dark:text-white flex items-center gap-3">
             <span class="w-2 h-8 bg-indigo-600 rounded-full"></span>
             سجل النشاط اليومي
        </h3>

        <div class="grid gap-6">
            @forelse($logs as $log)
                <div class="bg-white dark:bg-gray-800 p-8 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                    <div class="flex flex-col lg:flex-row gap-8">
                        <!-- Left Info -->
                        <div class="lg:w-1/4 flex flex-col items-center lg:items-start text-center lg:text-right shrink-0">
                            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-2xl flex items-center justify-center text-indigo-600 font-black text-2xl mb-4">
                                {{ mb_substr($log->user->name, 0, 1) }}
                            </div>
                            <h4 class="text-lg font-black text-gray-900 dark:text-white">{{ $log->user->name }}</h4>
                            <span class="text-xs font-bold text-gray-400">{{ $log->user->email }}</span>
                            
                            <div class="mt-4 px-3 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-full text-[10px] font-black uppercase">
                                {{ $log->project->name }}
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex-grow">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h5 class="text-xl font-black text-gray-900 dark:text-white mb-2">{{ $log->title }}</h5>
                                    <div class="flex items-center gap-4 text-xs font-bold text-gray-400">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            {{ (float)$log->hours }} ساعة
                                        </span>
                                        <span class="flex items-center gap-1 @if($log->status == 'done') text-green-500 @elseif($log->status == 'in_progress') text-blue-500 @else text-red-500 @endif">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                            {{ __('messages.' . $log->status) }}
                                        </span>
                                    </div>
                                </div>
                                <span class="text-[10px] font-bold text-gray-300">{{ $log->created_at->format('h:i A') }}</span>
                            </div>

                            <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed bg-gray-50 dark:bg-gray-900/40 p-6 rounded-2xl">
                                {{ $log->description }}
                            </p>

                            <!-- Comments Thread -->
                            <div class="mt-8 space-y-6">
                                <h6 class="text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50 dark:border-gray-700 pb-2">الملاحظات والتعليقات</h6>
                                
                                @foreach($log->comments as $comment)
                                    <div class="flex gap-4">
                                        <div class="w-8 h-8 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 shrink-0 font-black text-xs">
                                            {{ mb_substr($comment->admin->name, 0, 1) }}
                                        </div>
                                        <div class="bg-gray-50 dark:bg-gray-900/70 p-4 rounded-2xl relative shadow-sm border border-gray-100 dark:border-gray-700 flex-grow">
                                            <div class="flex justify-between items-center mb-1">
                                                <span class="text-[10px] font-black text-gray-900 dark:text-white">{{ $comment->admin->name }}</span>
                                                <span class="text-[9px] text-gray-400 font-bold">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $comment->comment }}</p>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Quick Reply -->
                                <div class="flex gap-4">
                                    <div class="w-8 h-8 rounded-xl bg-indigo-600 flex items-center justify-center text-white shrink-0 font-black text-xs">
                                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <div class="flex-grow flex gap-3 group">
                                        <input type="text" wire:model="commentTexts.{{ $log->id }}" placeholder="اضف توجيهاً أو تعليقاً..." class="block w-full px-5 py-3 bg-white dark:bg-gray-800 border-gray-100 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm transition font-medium">
                                        <button wire:click="addComment({{ $log->id }})" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-indigo-500/10 transition active:scale-[0.98] shrink-0">
                                            إرسال
                                        </button>
                                    </div>
                                </div>
                                @error('commentTexts.' . $log->id) <span class="text-red-500 text-[10px] mr-12">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800 p-20 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 text-center flex flex-col items-center">
                    <div class="w-24 h-24 bg-indigo-50 dark:bg-indigo-900/20 rounded-full flex items-center justify-center text-indigo-200 mb-6">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                    </div>
                    <h4 class="text-2xl font-black text-gray-900 dark:text-white">لا توجد سجلات مسجلة لليوم</h4>
                    <p class="text-gray-500 mt-2">عندما يقوم المطورون بإضافة مهامهم، ستظهر هنا فوراً.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
