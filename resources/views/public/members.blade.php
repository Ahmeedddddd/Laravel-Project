@extends('layouts.app')

@section('content')
<div class="container-page">
    <div class="flex items-start justify-between gap-4 flex-col sm:flex-row">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Members</h1>
            <p class="text-sm text-slate-600 mt-1">
                Publieke pagina (read-only). Zoek op username of weergavenaam en klik op een gebruiker om het publieke profiel te bekijken.
            </p>
        </div>

        <div class="text-sm text-slate-600">
            @auth
                <a class="btn-link" href="{{ route('dashboard') }}">Naar dashboard</a>
            @else
                @if (Route::has('login'))
                    <a class="btn-link" href="{{ route('login') }}">Log in</a>
                @endif
            @endauth
        </div>
    </div>

    <div class="mt-6 card">
        <form method="GET" action="{{ route('members.index') }}" class="space-y-3">
            <label for="q" class="block text-sm font-medium text-slate-700">Zoek op username of weergavenaam</label>

            <div class="flex flex-col sm:flex-row gap-2">
                <input
                    id="q"
                    name="q"
                    value="{{ $q }}"
                    placeholder="bv. ahmed of Ahmed B."
                    class="w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                    autocomplete="off"
                />
                <button type="submit" class="btn-primary shrink-0">Zoek</button>
            </div>

            @if ($q !== '')
                <div>
                    <a class="text-sm btn-link" href="{{ route('members.index') }}">Reset</a>
                </div>
            @endif
        </form>
    </div>

    <div class="mt-10">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-lg font-semibold text-slate-900">Gebruikers</h2>
            <p class="text-xs text-slate-500">{{ $profiles->total() }} resultaat{{ $profiles->total() === 1 ? '' : 'en' }}</p>
        </div>

        @if ($profiles->count() === 0)
            <div class="mt-4 card text-sm text-slate-600">
                Geen gebruikers gevonden.
            </div>
        @else
            <div class="mt-4 bg-white border border-slate-200 rounded-2xl divide-y divide-slate-100 overflow-hidden shadow-sm ring-1 ring-black/5">
                @foreach ($profiles as $profile)
                    <a
                        href="{{ route('public.users.show', ['username' => $profile->username]) }}"
                        class="flex items-center gap-3 p-4 hover:bg-emerald-50/60 focus:bg-emerald-50/60 focus:outline-none"
                    >
                        @if ($profile->avatar_url)
                            <img
                                src="{{ $profile->avatar_url }}"
                                alt="Profielfoto van {{ $profile->username }}"
                                class="w-10 h-10 rounded-full object-cover border border-slate-200"
                                loading="lazy"
                            />
                        @else
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 font-semibold">
                                {{ strtoupper(mb_substr($profile->username ?? 'U', 0, 1)) }}
                            </div>
                        @endif

                        <div class="min-w-0 flex-1">
                            <div class="font-medium truncate text-slate-900">{{ $profile->display_name ?: $profile->username }}</div>
                            <div class="text-sm text-slate-600 truncate">{{ '@' . $profile->username }}</div>
                        </div>

                        <div class="text-xs text-emerald-700 font-medium">Bekijk &rarr;</div>
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

