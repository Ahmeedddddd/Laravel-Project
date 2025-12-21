@php
    /** @var \Illuminate\Support\Collection|\Illuminate\Contracts\Pagination\Paginator|\Illuminate\Contracts\Pagination\LengthAwarePaginator $items */
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse ($items as $item)
        <a
            href="{{ route('news.show', $item) }}"
            class="group bg-white border border-slate-200 rounded-lg overflow-hidden hover:border-emerald-200 hover:shadow-sm transition"
        >
            <div class="aspect-[16/9] bg-slate-100">
                @if ($item->image_path)
                    <img
                        src="{{ asset('storage/' . $item->image_path) }}"
                        alt="{{ $item->title }}"
                        class="w-full h-full object-cover"
                        loading="lazy"
                    />
                @else
                    <div class="w-full h-full flex items-center justify-center text-xs text-slate-500">
                        Geen afbeelding
                    </div>
                @endif
            </div>

            <div class="p-4">
                <div class="font-semibold text-slate-900 group-hover:text-emerald-700 line-clamp-2">
                    {{ $item->title }}
                </div>
                <div class="text-xs text-slate-500 mt-1">
                    {{ optional($item->published_at)->format('d/m/Y H:i') }}
                </div>
                <p class="text-sm text-slate-700 mt-3 line-clamp-3">
                    {{ \Illuminate\Support\Str::limit($item->content, 140) }}
                </p>
                <div class="mt-3 text-sm text-emerald-700 underline">Lees meer</div>
            </div>
        </a>
    @empty
        <div class="bg-white border border-slate-200 rounded-lg p-6 text-sm text-slate-600">
            Geen nieuws beschikbaar.
        </div>
    @endforelse
</div>

