<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laatste nieuwtjes
        </h2>
    </x-slot>

    <div class="space-y-4">
        @forelse ($items as $item)
            <article class="bg-white border border-slate-200 rounded p-4 flex gap-4">
                @if ($item->image_path)
                    <a href="{{ route('news.show', $item) }}" class="shrink-0">
                        <img
                            src="{{ asset('storage/' . $item->image_path) }}"
                            alt="{{ $item->title }}"
                            class="w-28 h-20 object-cover rounded border"
                            loading="lazy"
                        />
                    </a>
                @endif

                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold text-lg leading-snug">
                        <a class="hover:underline" href="{{ route('news.show', $item) }}">
                            {{ $item->title }}
                        </a>
                    </h3>

                    <div class="text-xs text-slate-600 mt-1">
                        {{ optional($item->published_at)->format('d/m/Y H:i') }}
                        @if ($item->author)
                            <span class="mx-1">•</span>
                            <span>{{ $item->author->name }}</span>
                        @endif
                    </div>

                    <p class="text-sm text-slate-700 mt-2">
                        {{ \Illuminate\Support\Str::limit($item->content, 180) }}
                    </p>

                    <div class="mt-3">
                        <a class="text-sm underline" href="{{ route('news.show', $item) }}">Lees meer</a>
                    </div>
                </div>
            </article>
        @empty
            <div class="bg-white border border-slate-200 rounded p-4">
                Nog geen nieuws.
            </div>
        @endforelse

        <div>
            {{ $items->links() }}
        </div>
    </div>
</x-app-layout>

