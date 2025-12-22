@extends('layouts.admin')

@section('title', 'FAQ vraag bewerken')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">FAQ vraag bewerken</h1>
        <a href="{{ route('admin.items.index') }}" class="underline">Terug</a>
    </div>

    <div class="bg-white border rounded p-6">
        <form method="POST" action="{{ route('admin.items.update', $item) }}" class="space-y-4">
            @csrf
            @method('PUT')

            @include('admin.faq.items._form', ['item' => $item, 'categories' => $categories])

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Opslaan</button>
        </form>
    </div>
@endsection

