<x-mail::message>
    # New task created

    A new task has been added to your To-Do list:

    - **Title:** {{ $task->title }}
    @if ($task->description)
        - **Description:** {{ $task->description }}
    @endif
    @if ($task->due_date)
        - **Due date:** {{ $task->due_date->format('d.m.Y') }}
    @endif
    - **Important:** {{ $task->is_important ? 'Yes' : 'No' }}

    <x-mail::button :url="url('/')">
        Open To-Do List
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
