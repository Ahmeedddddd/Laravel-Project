@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between gap-4">
        <a class="text-sm underline text-gray-600" href="{{ route('home') }}">← Terug naar zoeken</a>

        <div class="text-sm text-gray-600">
            @auth
                <a class="underline" href="{{ route('profile.edit') }}">Mijn profiel</a>
            @else
                @if (Route::has('login'))
                    <a class="underline" href="{{ route('login') }}">Log in</a>
                @endif
            @endauth
        </div>
    </div>

    <div class="mt-6 bg-white border border-gray-200 rounded-lg p-6">
        <div class="flex items-start gap-4">
            @if ($profile->avatar_url)
                <img
                    src="{{ $profile->avatar_url }}"
                    alt="Profielfoto van {{ $profile->username }}"
                    class="w-24 h-24 rounded-full object-cover border"
                />
            @else
                <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 font-semibold text-3xl">
                    {{ strtoupper(mb_substr($profile->username ?? 'U', 0, 1)) }}
                </div>
            @endif

            <div class="flex-1">
                <h1 class="text-2xl font-semibold">
                    {{ $profile->display_name ?: $profile->username }}
                </h1>
                <p class="text-gray-600 mt-1">{{ '@' . $profile->username }}</p>

                @if ($profile->birthday)
                    <p class="text-sm text-gray-600 mt-3">
                        <span class="font-medium">Verjaardag:</span>
                        {{ $profile->birthday->format('d/m/Y') }}
                    </p>
                @endif
            </div>
        </div>

        <div class="mt-6">
            <h2 class="text-lg font-semibold">Over mij</h2>

            @if ($profile->bio)
                <p class="mt-2 text-gray-800 whitespace-pre-line">{{ $profile->bio }}</p>
            @else
                <p class="mt-2 text-gray-600 text-sm">Geen "over mij" tekst ingevuld.</p>
            @endif
        </div>

        <div class="mt-8 border-t pt-4 text-xs text-gray-500">
            Dit is een publieke, read-only profielpagina.
        </div>
    </div>
</div>
@endsection

