<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laatste nieuwtjes
        </h2>
    </x-slot>

    <div class="space-y-4">
        <p class="text-sm text-slate-600">Nieuws overzicht (skeleton).</p>

        @forelse ($items as $item)
            <div class="bg-white border border-slate-200 rounded p-4">
                <div class="font-semibold">
                    <a class="underline" href="{{ route('news.show', $item) }}">
                        {{ $item->title }}
                    </a>
                </div>
                <div class="text-sm text-slate-600">
                    Gepubliceerd: {{ optional($item->published_at)->format('Y-m-d H:i') }}
                </div>
            </div>
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

