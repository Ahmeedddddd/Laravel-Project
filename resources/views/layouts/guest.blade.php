<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="moskee-al-khalil">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 py-10 bg-gradient-to-b from-emerald-50 via-slate-50 to-slate-50">
            <div class="w-full max-w-md">
                <div class="flex items-center justify-center">
                    <a href="/" class="inline-flex items-center gap-3 no-underline">
                        <x-application-logo class="w-12 h-12 fill-current text-emerald-700" />
                        <span class="text-lg font-semibold tracking-tight text-slate-900">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                </div>

                <div class="mt-6 bg-white/90 backdrop-blur border border-slate-200 shadow-sm ring-1 ring-black/5 overflow-hidden rounded-2xl p-6 sm:p-8">
                    {{ $slot }}
                </div>

                <div class="mt-6 text-center text-xs text-slate-500">
                    <span class="font-medium text-emerald-700">Tip:</span> gebruik een sterk wachtwoord en bewaar het veilig.
                </div>
            </div>
        </div>
    </body>
</html>
