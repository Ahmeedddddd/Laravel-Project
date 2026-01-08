@extends('layouts.admin')

@section('title', 'FAQ categorie bewerken')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">FAQ categorie bewerken</h1>
        <a href="{{ route('admin.categories.index') }}" class="underline">Terug</a>
    </div>

    <div class="bg-white border rounded p-6">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-4">
            @csrf
            @method('PUT')

            @include('admin.faq.categories._form', ['category' => $category])

            <x-admin-button type="submit">Opslaan</x-admin-button>
        </form>
    </div>
@endsection
