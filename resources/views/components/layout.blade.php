<!DOCTYPE html>
<html lang="en" data-theme="lofi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'ToDoList - Home' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex flex-col bg-sky-100 font-sans text-slate-800">
<nav class="navbar bg-white/90 border-b border-sky-200 px-6">
    <div class="navbar-start">
        <a href="/" class="btn btn-ghost rounded-full text-xl font-bold text-slate-800">ToDo List</a>
    </div>


    <div class="navbar-end gap-2">
        @auth
            <span class="text-sm font-medium text-slate-700">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="btn btn-ghost btn-sm rounded-full">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-ghost btn-sm rounded-full">Sign In</a>
            <a href="{{ route('register') }}" class="btn btn-sm rounded-full border-none px-5 text-white" style="background-color: #0284c7;">Sign Up</a>
        @endauth
    </div>
</nav>


@if (session('success'))
    <div class="toast toast-top toast-center z-50">
        <div class="alert bg-emerald-600 text-white border-none rounded-2xl shadow-md text-sm">
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif

<main class="flex-1 container mx-auto px-4 py-8">
    {{ $slot }}
</main>

<footer class="footer footer-center p-5 bg-sky-200/70 text-slate-600 text-xs">
    <div>
        <p>© 2026 ToDoList - Built with Laravel and ❤️</p>
    </div>
</footer>
</body>

</html>
