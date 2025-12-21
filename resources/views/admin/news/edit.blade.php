@extends('layouts.admin')

@section('title', 'Nieuwsitem bewerken')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Nieuwsitem bewerken</h1>

    <div class="bg-white border rounded p-4">
        <form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            @if ($errors->any())
                <div class="mb-4 p-3 rounded bg-red-50 text-red-800 border border-red-200">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label class="block text-sm font-medium">Titel</label>
                <input name="title" value="{{ old('title', $news->title) }}" class="w-full border rounded px-3 py-2" />
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium">Publicatiedatum</label>
                <input name="published_at" type="datetime-local" value="{{ old('published_at', optional($news->published_at)->format('Y-m-d\\TH:i')) }}" class="w-full border rounded px-3 py-2" />
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium">Afbeelding vervangen (optioneel)</label>
                @if ($news->image_path)
                    <div class="text-xs text-gray-600 mb-1">Huidige: {{ $news->image_path }}</div>
                @endif
                <input name="image" type="file" accept="image/*" class="w-full border rounded px-3 py-2 bg-white" />
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium">Content</label>
                <textarea name="content" rows="6" class="w-full border rounded px-3 py-2">{{ old('content', $news->content) }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Opslaan</button>
                <a href="{{ route('admin.news.index') }}" class="underline">Annuleren</a>
            </div>
        </form>
    </div>
@endsection

