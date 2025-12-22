@php
    /** @var \Illuminate\Support\Collection<int, \App\Models\FaqCategory> $categories */
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('FAQ') }}
        </h2>
    </x-slot>

    <div class="space-y-8">
        @forelse ($categories as $category)
            <section class="bg-white border border-slate-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-slate-900">
                    {{ $category->name }}
                </h3>

                <div class="mt-4 space-y-3">
                    @forelse ($category->items as $item)
                        <details class="group rounded-md border border-slate-100 bg-slate-50 px-4 py-3">
                            <summary class="cursor-pointer select-none font-medium text-slate-800 group-open:text-emerald-700">
                                {{ $item->question }}
                            </summary>
                            <div class="mt-2 text-sm text-slate-700 whitespace-pre-line">
                                {{ $item->answer }}
                            </div>
                        </details>
                    @empty
                        <div class="text-sm text-slate-600">
                            Geen vragen in deze categorie.
                        </div>
                    @endforelse
                </div>
            </section>
        @empty
            <div class="bg-white border border-slate-200 rounded-lg p-6 text-sm text-slate-600">
                Er zijn nog geen FAQ-categorieen.
            </div>
        @endforelse
    </div>
</x-app-layout>

