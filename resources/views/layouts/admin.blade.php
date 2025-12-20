<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">
    <header class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.dashboard') }}" class="font-semibold">Admin</a>
                <nav class="flex items-center gap-3 text-sm">
                    <a href="{{ route('admin.dashboard') }}" class="hover:underline">Dashboard</a>
                    <a href="{{ route('admin.users.index') }}" class="hover:underline">Users</a>
                </nav>
            </div>

            <div class="text-sm">
                <span class="text-gray-600">{{ auth()->user()->email ?? '' }}</span>
                <form class="inline" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="ml-3 underline">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-6">
        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-50 text-green-800 border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>

