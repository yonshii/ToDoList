<?php

use App\Models\Task;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public string $search = '';

    public string $filter = 'all';

    public function setFilter(string $filter): void
    {
        if (in_array($filter, ['all', 'open', 'completed'], true)) {
            $this->filter = $filter;
            unset($this->tasks);
        }
    }

    public function updatedSearch(): void
    {
        unset($this->tasks);
    }

    #[Computed]
    public function allTasks(): Collection
    {
        if (! auth()->check()) {
            return collect();
        }

        return Task::query()
            ->where('user_id', auth()->id())
            ->orderBy('is_completed')
            ->orderByDesc('is_important')
            ->orderByRaw('due_date IS NULL, due_date ASC')
            ->latest()
            ->get();
    }

    #[Computed]
    public function tasks(): Collection
    {
        $query = $this->allTasks;

        if ($this->filter === 'open') {
            $query = $query->where('is_completed', false);
        } elseif ($this->filter === 'completed') {
            $query = $query->where('is_completed', true);
        }

        $term = mb_strtolower(trim($this->search));

        if ($term !== '') {
            $query = $query->filter(function (Task $task) use ($term): bool {
                $titleMatch = str_contains(mb_strtolower($task->title), $term);
                $descriptionMatch = $task->description !== null
                    && str_contains(mb_strtolower($task->description), $term);

                return $titleMatch || $descriptionMatch;
            });
        }

        return $query->values();
    }

    #[Computed]
    public function completedCount(): int
    {
        return $this->allTasks->where('is_completed', true)->count();
    }

    #[Computed]
    public function remainingCount(): int
    {
        return $this->allTasks->where('is_completed', false)->count();
    }

    public function toggleComplete(int $taskId): void
    {
        if (! auth()->check()) {
            return;
        }

        $task = Task::query()->find($taskId);

        if (! $task || $task->user_id !== auth()->id()) {
            abort(403);
        }

        $task->update([
            'is_completed' => ! $task->is_completed,
        ]);

        unset($this->allTasks, $this->tasks, $this->completedCount, $this->remainingCount);
    }

    public function deleteTask(int $taskId): void
    {
        if (! auth()->check()) {
            return;
        }

        $task = Task::query()->find($taskId);

        if (! $task || $task->user_id !== auth()->id()) {
            abort(403);
        }

        $task->delete();

        unset($this->allTasks, $this->tasks, $this->completedCount, $this->remainingCount);
    }
};
?>

<div>
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-4 text-sm bg-sky-50 px-3.5 py-1.5 rounded-full border border-sky-200 w-fit">
            <span class="text-emerald-700">Completed: <strong>{{ $this->completedCount }}</strong></span>
            <span class="text-slate-300">|</span>
            <span class="text-rose-600 font-medium">Remaining: <strong>{{ $this->remainingCount }}</strong></span>
            <span class="text-slate-300">|</span>
            <span class="text-slate-600">Total: <strong>{{ $this->allTasks->count() }}</strong></span>
        </div>
    </div>

    <div class="mt-4 bg-white/95 border border-sky-200 rounded-2xl p-3.5 shadow-sm flex flex-col sm:flex-row gap-3 items-stretch sm:items-center justify-between">
        <input
            type="text"
            wire:model.live.debounce.250ms="search"
            placeholder="Search tasks by title or description..."
            class="input input-bordered input-sm sm:input-md flex-1 rounded-xl border-sky-200 bg-white focus:border-sky-500 focus:outline-none"
        >

        <div class="join shrink-0 self-end sm:self-auto">
            <button
                type="button"
                wire:click="setFilter('all')"
                class="btn btn-sm join-item rounded-l-full {{ $filter === 'all' ? 'bg-sky-600 text-white border-sky-600' : 'bg-white text-slate-700 border-sky-200' }}"
            >
                All
            </button>
            <button
                type="button"
                wire:click="setFilter('open')"
                class="btn btn-sm join-item {{ $filter === 'open' ? 'bg-sky-600 text-white border-sky-600' : 'bg-white text-slate-700 border-sky-200' }}"
            >
                Open
            </button>
            <button
                type="button"
                wire:click="setFilter('completed')"
                class="btn btn-sm join-item rounded-r-full {{ $filter === 'completed' ? 'bg-sky-600 text-white border-sky-600' : 'bg-white text-slate-700 border-sky-200' }}"
            >
                Completed
            </button>
        </div>
    </div>

    <div class="mt-6 space-y-3">
        @forelse ($this->tasks as $task)
            @php
                $cardClasses = $task->is_completed
                    ? 'bg-slate-100 border border-slate-300 opacity-75'
                    : ($task->is_important
                        ? 'bg-rose-50/40 border-2 border-rose-400'
                        : 'bg-white/95 border border-sky-200/80');
            @endphp

            <div wire:key="task-{{ $task->id }}" class="card shadow-sm rounded-2xl transition hover:shadow-md {{ $cardClasses }}">
                <div class="card-body flex-row items-start justify-between gap-4 py-4">
                    <div class="{{ $task->is_completed ? 'line-through text-slate-500' : '' }}">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-semibold text-lg {{ $task->is_completed ? 'text-slate-500' : 'text-slate-800' }}">
                                {{ $task->title }}
                            </span>

                            @if ($task->is_important && ! $task->is_completed)
                                <span class="badge badge-sm bg-rose-100 text-rose-700 border-rose-300 font-medium">
                                    Important
                                </span>
                            @endif

                            @if ($task->due_date)
                                <span class="badge badge-sm bg-sky-100 text-sky-800 border-sky-200">
                                    Due: {{ $task->due_date->format('d.m.Y') }}
                                </span>
                            @endif
                        </div>

                        @if ($task->description)
                            <p class="text-sm {{ $task->is_completed ? 'text-slate-400' : 'text-slate-600' }} mt-1">
                                {{ $task->description }}
                            </p>
                        @endif

                        <div class="text-xs text-slate-400 mt-2">
                            Created {{ $task->created_at->diffForHumans() }}
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <button
                            type="button"
                            wire:click="toggleComplete({{ $task->id }})"
                            class="btn btn-sm rounded-full {{ $task->is_completed ? 'bg-slate-200 text-slate-700 border-slate-300' : 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' }}"
                        >
                            {{ $task->is_completed ? 'Return' : 'Done' }}
                        </button>

                        <button
                            type="button"
                            wire:click="deleteTask({{ $task->id }})"
                            class="btn btn-sm rounded-full btn-outline border-rose-300 text-rose-600 hover:bg-rose-600 hover:border-rose-600 hover:text-white"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white/75 border border-dashed border-sky-300 rounded-2xl py-8 px-4 text-center text-slate-500">
                @if ($search !== '' || $filter !== 'all')
                    No matching tasks found for the current filter or search.
                @else
                    There are no tasks yet — add your first task above.
                @endif
            </div>
        @endforelse
    </div>
</div>
