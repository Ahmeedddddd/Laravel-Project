@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="flex items-start justify-between gap-4 flex-col sm:flex-row">
        <div>
            <h1 class="text-2xl font-semibold">Zoek gebruikers</h1>
            <p class="text-sm text-gray-600 mt-1">Publieke pagina (read-only). Klik op een gebruiker om het publieke profiel te bekijken.</p>
        </div>

        <div class="text-sm text-gray-600">
            @auth
                <a class="underline" href="{{ route('dashboard') }}">Naar dashboard</a>
            @else
                @if (Route::has('login'))
                    <a class="underline" href="{{ route('login') }}">Log in</a>
                @endif
            @endauth
        </div>
    </div>

    <div class="mt-6 bg-white border border-gray-200 rounded-lg p-4 sm:p-6">
        <form method="GET" action="{{ route('home') }}">
            <label for="q" class="block text-sm font-medium text-gray-700">Zoek op username of weergavenaam</label>
            <div class="mt-2 flex flex-col sm:flex-row gap-2">
                <input
                    id="q"
                    name="q"
                    value="{{ $q }}"
                    placeholder="bv. ahmed of Ahmed B."
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    autocomplete="off"
                />
                <button type="submit" class="shrink-0 px-4 py-2 rounded-md bg-indigo-600 text-white">Zoek</button>
            </div>
            @if ($q !== '')
                <div class="mt-2">
                    <a class="text-sm underline text-gray-600" href="{{ route('home') }}">Reset</a>
                </div>
            @endif
        </form>
    </div>

    <div class="mt-8">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-lg font-semibold">Laatste nieuwtjes</h2>
            <a class="text-sm underline text-slate-600 hover:text-emerald-700" href="{{ route('news.index') }}">Alle nieuws</a>
        </div>

        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($latestNews as $item)
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
    </div>

    <div class="mt-8">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-lg font-semibold">Gebruikers</h2>
            <p class="text-xs text-gray-500">{{ $profiles->total() }} resultaat{{ $profiles->total() === 1 ? '' : 'en' }}</p>
        </div>

        @if ($profiles->count() === 0)
            <div class="mt-4 bg-white border border-gray-200 rounded-lg p-6 text-sm text-gray-600">
                Geen gebruikers gevonden.
            </div>
        @else
            <div class="mt-4 bg-white border border-gray-200 rounded-lg divide-y">
                @foreach ($profiles as $profile)
                    <a
                        href="{{ route('public.users.show', ['username' => $profile->username]) }}"
                        class="flex items-center gap-3 p-4 hover:bg-gray-50 focus:bg-gray-50"
                    >
                        @if ($profile->avatar_url)
                            <img
                                src="{{ $profile->avatar_url }}"
                                alt="Profielfoto van {{ $profile->username }}"
                                class="w-10 h-10 rounded-full object-cover border"
                                loading="lazy"
                            />
                        @else
                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 font-semibold">
                                {{ strtoupper(mb_substr($profile->username ?? 'U', 0, 1)) }}
                            </div>
                        @endif

                        <div class="min-w-0 flex-1">
                            <div class="font-medium truncate">{{ $profile->display_name ?: $profile->username }}</div>
                            <div class="text-sm text-gray-600 truncate">{{ '@' . $profile->username }}</div>
                        </div>

                        <div class="text-xs text-gray-400">Bekijk &rarr;</div>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $profiles->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

