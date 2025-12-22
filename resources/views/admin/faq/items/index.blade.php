@extends('layouts.admin')

@section('title', 'FAQ items')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">FAQ items</h1>
        <a href="{{ route('admin.items.create') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded">Nieuwe vraag</a>
    </div>

    <div class="bg-white border rounded overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left p-3">Categorie</th>
                    <th class="text-left p-3">Vraag</th>
                    <th class="text-left p-3">Acties</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr class="border-t">
                        <td class="p-3 text-gray-700">{{ $item->category?->name }}</td>
                        <td class="p-3">{{ $item->question }}</td>
                        <td class="p-3">
                            <a class="underline" href="{{ route('admin.items.edit', $item) }}">Bewerken</a>

                            <form method="POST" action="{{ route('admin.items.destroy', $item) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-3 underline text-red-700" onclick="return confirm('Ben je zeker?')">Verwijderen</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t">
                        <td class="p-3" colspan="3">Nog geen vragen.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

