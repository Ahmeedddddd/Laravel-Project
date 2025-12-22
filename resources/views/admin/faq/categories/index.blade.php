@extends('layouts.admin')

@section('title', 'FAQ categorieen')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">FAQ categorieen</h1>
        <a href="{{ route('admin.categories.create') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded">Nieuwe categorie</a>
    </div>

    <div class="bg-white border rounded overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left p-3">Naam</th>
                    <th class="text-left p-3"># vragen</th>
                    <th class="text-left p-3">Acties</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr class="border-t">
                        <td class="p-3">{{ $category->name }}</td>
                        <td class="p-3 text-gray-600">{{ $category->items_count }}</td>
                        <td class="p-3">
                            <a class="underline" href="{{ route('admin.categories.edit', $category) }}">Bewerken</a>

                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-3 underline text-red-700" onclick="return confirm('Ben je zeker? Dit verwijdert ook de vragen in deze categorie.')">Verwijderen</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t">
                        <td class="p-3" colspan="3">Nog geen FAQ categorieen.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
