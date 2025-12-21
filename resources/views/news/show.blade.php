<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nieuws
        </h2>
    </x-slot>

    <div class="bg-white border border-slate-200 rounded p-6 space-y-2">
        <div class="text-2xl font-semibold">{{ $news->title }}</div>
        <div class="text-sm text-slate-600">
            Gepubliceerd: {{ optional($news->published_at)->format('Y-m-d H:i') }}
        </div>

        <div class="pt-4">
            <p class="text-sm text-slate-600">Detailpagina (skeleton).</p>
            <div class="mt-2 whitespace-pre-line">{{ $news->content }}</div>
        </div>

        <div class="pt-4">
            <a class="underline" href="{{ route('news.index') }}">Terug naar overzicht</a>
        </div>
    </div>
</x-app-layout>

