@extends('layouts.admin')

@section('title', 'News beheer')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">News beheer</h1>
        <a href="{{ route('admin.news.create') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded">Nieuw nieuwsitem</a>
    </div>

    <div class="bg-white border rounded overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left p-3">Titel</th>
                    <th class="text-left p-3">Publicatie</th>
                    <th class="text-left p-3">Acties</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr class="border-t">
                        <td class="p-3">{{ $item->title }}</td>
                        <td class="p-3 text-gray-600">{{ optional($item->published_at)->format('Y-m-d H:i') }}</td>
                        <td class="p-3">
                            <a class="underline" href="{{ route('admin.news.edit', $item) }}">Bewerken</a>

                            <form method="POST" action="{{ route('admin.news.destroy', $item) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-3 underline text-red-700" onclick="return confirm('Ben je zeker?')">Verwijderen</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t">
                        <td class="p-3" colspan="3">Nog geen nieuwsitems.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $items->links() }}
    </div>
@endsection

