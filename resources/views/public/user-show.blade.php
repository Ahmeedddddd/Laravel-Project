@extends('layouts.app')

@section('content')
<div class="container-page max-w-3xl">
    <div class="flex items-center justify-between gap-4">
        <a class="text-sm btn-link inline-flex items-center gap-2" href="{{ route('home') }}">
            <span aria-hidden="true">&larr;</span>
            Terug naar zoeken
        </a>

        <div class="text-sm text-slate-600">
            @auth
                <a class="btn-link" href="{{ route('profile.edit') }}">Mijn profiel</a>
            @else
                @if (Route::has('login'))
                    <a class="btn-link" href="{{ route('login') }}">Log in</a>
                @endif
            @endauth
        </div>
    </div>

    <div class="mt-6 card">
        <div class="flex items-start gap-5">
            @if ($profile->avatar_url)
                <img
                    src="{{ $profile->avatar_url }}"
                    alt="Profielfoto van {{ $profile->username }}"
                    class="w-24 h-24 rounded-full object-cover border border-slate-200"
                />
            @else
                <div class="w-24 h-24 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-800 font-semibold text-3xl border border-emerald-100">
                    {{ strtoupper(mb_substr($profile->username ?? 'U', 0, 1)) }}
                </div>
            @endif

            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3 flex-wrap">
                    <h1 class="text-2xl font-semibold tracking-tight text-slate-900">
                        {{ $profile->display_name ?: $profile->username }}
                    </h1>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-800 border border-emerald-100">
                        {{ '@' . $profile->username }}
                    </span>
                </div>

                @if ($profile->birthday)
                    <p class="text-sm text-slate-600 mt-3">
                        <span class="font-medium text-slate-700">Verjaardag:</span>
                        {{ $profile->birthday->format('d/m/Y') }}
                    </p>
                @endif
            </div>
        </div>

        <div class="mt-8">
            <h2 class="text-lg font-semibold text-slate-900">Over mij</h2>

            @if ($profile->bio)
                <p class="mt-2 text-slate-800 whitespace-pre-line leading-relaxed">{{ $profile->bio }}</p>
            @else
                <p class="mt-2 text-slate-600 text-sm">Geen "over mij" tekst ingevuld.</p>
            @endif
        </div>

        <div class="mt-8 border-t border-slate-200 pt-4 text-xs text-slate-500">
            Dit is een publieke, read-only profielpagina.
        </div>
    </div>
</div>
@endsection

