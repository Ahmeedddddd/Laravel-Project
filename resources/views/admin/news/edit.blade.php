@extends('layouts.admin')

@section('title', 'Nieuwsitem bewerken')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Nieuwsitem bewerken</h1>

    <div class="bg-white border rounded p-4">
        <p class="text-gray-600 text-sm mb-4">Edit form (skeleton). Validatie + upload komt in stap 5.</p>

        <form method="POST" action="{{ route('admin.news.update', $news) }}">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label class="block text-sm font-medium">Titel</label>
                <input name="title" value="{{ $news->title }}" class="w-full border rounded px-3 py-2" />
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium">Publicatiedatum</label>
                <input name="published_at" type="datetime-local" value="{{ optional($news->published_at)->format('Y-m-d\\TH:i') }}" class="w-full border rounded px-3 py-2" />
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium">Content</label>
                <textarea name="content" rows="6" class="w-full border rounded px-3 py-2">{{ $news->content }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Opslaan</button>
                <a href="{{ route('admin.news.index') }}" class="underline">Annuleren</a>
            </div>
        </form>
    </div>
@endsection

