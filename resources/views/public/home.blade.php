@extends('layouts.app')

@section('content')
<div class="container-page">
    <div class="flex items-start justify-between gap-4 flex-col sm:flex-row">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Zoek gebruikers</h1>
            <p class="text-sm text-slate-600 mt-1">
                Publieke pagina (read-only). Klik op een gebruiker om het publieke profiel te bekijken.
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

    <div class="mt-6">
        <x-profile-search-form
            :action="route('home')"
            :q="$q"
            :reset-url="route('home')"
        />
    </div>

    <div class="mt-10">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-lg font-semibold text-slate-900">Laatste nieuwtjes</h2>
            <a class="text-sm btn-link" href="{{ route('news.index') }}">Alle nieuws</a>
        </div>

        <div class="mt-4">
            @include('partials.news-cards', ['items' => $latestNews])
        </div>
    </div>

    <div class="mt-10">
        <x-profile-search-results :profiles="$profiles" />
    </div>
</div>
@endsection

