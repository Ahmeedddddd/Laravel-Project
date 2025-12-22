@extends('layouts.admin')

@section('title', 'FAQ categorie toevoegen')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">FAQ categorie toevoegen</h1>
        <a href="{{ route('admin.categories.index') }}" class="underline">Terug</a>
    </div>

    <div class="bg-white border rounded p-6">
        <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
            @csrf

            @include('admin.faq.categories._form', ['category' => null])

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Opslaan</button>
        </form>
    </div>
@endsection
