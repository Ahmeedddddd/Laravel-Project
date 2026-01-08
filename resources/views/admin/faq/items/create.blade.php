@extends('layouts.admin')

@section('title', 'FAQ vraag toevoegen')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">FAQ vraag toevoegen</h1>
        <a href="{{ route('admin.items.index') }}" class="underline">Terug</a>
    </div>

    <div class="bg-white border rounded p-6">
        <form method="POST" action="{{ route('admin.items.store') }}" class="space-y-4">
            @csrf

            @include('admin.faq.items._form', ['item' => null, 'categories' => $categories])

            <x-admin-button type="submit">Opslaan</x-admin-button>
        </form>
    </div>
@endsection

