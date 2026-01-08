@props([
    'variant' => 'primary',
])

@php
    $base = 'inline-flex items-center justify-center px-4 py-2 rounded text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 transition';

    $variants = [
        // Default admin button: green background + white text
        'primary' => 'bg-green-600 hover:bg-green-700 text-white focus:ring-green-500',
        // Optional variants (handy for later)
        'danger' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
        'secondary' => 'bg-slate-100 hover:bg-slate-200 text-slate-800 focus:ring-slate-400',
        'link' => 'bg-transparent text-green-700 hover:text-green-800 underline focus:ring-green-500',
    ];

    $classes = $base . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

<button {{ $attributes->merge(['type' => 'button', 'class' => $classes]) }}>
    {{ $slot }}
</button>

