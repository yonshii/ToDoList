<x-layout>
    <x-slot:title>
        To-Do List
    </x-slot:title>

    <div class="max-w-2xl mx-auto">
        <div class="card bg-white/95 shadow-md border border-sky-200 rounded-2xl">
            <div class="card-body">
                <h1 class="text-3xl font-bold text-slate-800">To-Do List</h1>
                <p class="text-slate-500 mt-1">Add tasks, mark them as complete, and remove anything you don’t need.</p>

                <form action="/tasks" method="POST" class="mt-4 space-y-3">
                    @csrf

                    <div>
                        <input
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            placeholder="Task name (required, up to 255 characters)"
                            class="input input-bordered w-full rounded-xl border-sky-200 bg-white focus:border-sky-500 focus:outline-none"
                            required
                            maxlength="255"
                        >
                        @error('title')
                        <p class="text-rose-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <textarea
                            name="description"
                            rows="2"
                            placeholder="Description (optional)"
                            class="textarea textarea-bordered w-full rounded-xl border-sky-200 bg-white focus:border-sky-500 focus:outline-none"
                        >{{ old('description') }}</textarea>
                        @error('description')
                        <p class="text-rose-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-center pt-1">
                        <div>
                            <label class="block text-xs text-slate-500 mb-1">Due date (optional)</label>
                            <input
                                type="date"
                                name="due_date"
                                value="{{ old('due_date') }}"
                                class="input input-bordered w-full rounded-xl border-sky-200 bg-white focus:border-sky-500 focus:outline-none"
                            >
                            @error('due_date')
                            <p class="text-rose-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <label class="flex items-center gap-2.5 cursor-pointer pt-4 sm:pt-5 select-none">
                            <input
                                type="checkbox"
                                name="is_important"
                                value="1"
                                @checked(old('is_important'))
                                class="checkbox checkbox-error rounded-md"
                            >
                            <span class="text-sm font-medium text-slate-700">Mark as important</span>
                        </label>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button
                            type="submit"
                            class="btn rounded-full bg-sky-600 hover:bg-sky-700 text-white border-none px-6"
                        >
                            Add task
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-6">
            <livewire:task-list />
        </div>
    </div>
</x-layout>
