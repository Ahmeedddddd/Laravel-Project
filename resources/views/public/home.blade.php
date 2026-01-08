@extends('layouts.app')

@section('content')
<div class="container-page">
    <div class="flex items-start justify-between gap-4 flex-col sm:flex-row">
        <div>
            <h1 class="text-3xl sm:text-4xl font-semibold tracking-tight text-slate-900">Moskee <span class="text-emerald-700">Al Khalil</span></h1>
            <p class="text-sm text-slate-600 mt-2 max-w-prose">
                Welkom bij Moskee Al Khalil. Bekijk het laatste nieuws, of ga naar <a class="btn-link" href="{{ route('members.index') }}">Members</a> om gebruikers te zoeken.
            </p>
        </div>
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
</div>
@endsection

