@extends('layouts.app')

@section('content')
<div class="container-page">
    <div class="flex items-start justify-between gap-4 flex-col sm:flex-row">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Zoek gebruikers</h1>
            <p class="text-sm text-slate-600 mt-1">
                Alleen zichtbaar voor ingelogde gebruikers. Klik op een resultaat om het publieke profiel te bekijken.
            </p>
        </div>

        <div class="text-sm text-slate-600">
            <a class="btn-link" href="{{ route('dashboard') }}">Naar dashboard</a>
        </div>
    </div>

    <div class="mt-6">
        <x-profile-search-form
            :action="route('users.search')"
            :q="$q"
            :reset-url="route('users.search')"
            :suggest-url="route('users.suggest')"
        />
    </div>

    <div class="mt-4">
        <x-profile-search-results :profiles="$profiles" />
    </div>
</div>
@endsection

