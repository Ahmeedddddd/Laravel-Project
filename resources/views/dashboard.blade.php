<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>


            <div>
                <div class="flex items-center justify-between gap-4">
                    <h2 class="text-lg font-semibold">Laatste nieuwtjes</h2>
                    <a class="text-sm underline text-slate-600 hover:text-emerald-700" href="{{ route('news.index') }}">Alle nieuws</a>
                </div>

                <div class="mt-4">
                    @include('partials.news-cards', ['items' => ($latestNews ?? collect())])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
