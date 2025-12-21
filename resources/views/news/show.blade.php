<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $news->title }}
            </h2>
            <div class="text-sm text-slate-600 mt-1">
                {{ optional($news->published_at)->format('d/m/Y H:i') }}
                @if ($news->author)
                    <span class="mx-1">•</span>
                    <span>{{ $news->author->name }}</span>
                @endif
            </div>
        </div>
    </x-slot>

    <article class="bg-white border border-slate-200 rounded p-6 space-y-5">
        @if ($news->image_path)
            <div>
                <img
                    src="{{ asset('storage/' . $news->image_path) }}"
                    alt="{{ $news->title }}"
                    class="w-full max-h-[420px] object-cover rounded border"
                />
            </div>
        @endif

        <div class="prose prose-slate max-w-none">
            <div class="whitespace-pre-line">{{ $news->content }}</div>
        </div>

        <div>
            <a class="text-sm underline" href="{{ route('news.index') }}">Terug naar overzicht</a>
        </div>
    </article>
</x-app-layout>

