@extends('layouts.admin')

@section('title', 'Nieuw nieuwsitem')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Nieuw nieuwsitem</h1>

    <div class="bg-white border rounded p-4">
        <p class="text-gray-600 text-sm mb-4">Create form (skeleton). Validatie + upload komt in stap 4.</p>

        <form method="POST" action="{{ route('admin.news.store') }}">
            @csrf

            <div class="mb-3">
                <label class="block text-sm font-medium">Titel</label>
                <input name="title" class="w-full border rounded px-3 py-2" />
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium">Publicatiedatum</label>
                <input name="published_at" type="datetime-local" class="w-full border rounded px-3 py-2" />
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium">Content</label>
                <textarea name="content" rows="6" class="w-full border rounded px-3 py-2"></textarea>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Opslaan</button>
                <a href="{{ route('admin.news.index') }}" class="underline">Annuleren</a>
            </div>
        </form>
    </div>
@endsection

