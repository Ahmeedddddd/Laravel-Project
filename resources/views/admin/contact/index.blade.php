@extends('layouts.admin')

@section('title', 'Contact inbox')

@section('content')
    <div class="flex items-start justify-between gap-4 flex-col sm:flex-row">
        <div>
            <h1 class="text-2xl font-bold">Contact inbox</h1>
            <p class="text-sm text-gray-600 mt-1">Alle berichten die via het contactformulier zijn verstuurd.</p>
        </div>

        <form method="GET" action="{{ route('admin.contact.index') }}" class="flex gap-2">
            <input name="q" value="{{ $q }}" placeholder="Zoek op naam, e-mail, onderwerp…" class="border rounded px-3 py-2" />
            <button class="px-4 py-2 bg-emerald-700 text-white rounded">Zoeken</button>
        </form>
    </div>

    <div class="mt-6 bg-white border rounded overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="text-left p-3">Status</th>
                    <th class="text-left p-3">Van</th>
                    <th class="text-left p-3">Onderwerp</th>
                    <th class="text-left p-3">Datum</th>
                    <th class="text-left p-3">Actie</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $m)
                    <tr class="border-t">
                        <td class="p-3">
                            @if($m->replied_at)
                                <span class="px-2 py-1 rounded bg-emerald-50 text-emerald-700">Beantwoord</span>
                            @elseif($m->read_at)
                                <span class="px-2 py-1 rounded bg-amber-50 text-amber-700">Gelezen</span>
                            @else
                                <span class="px-2 py-1 rounded bg-slate-100 text-slate-700">Nieuw</span>
                            @endif
                        </td>
                        <td class="p-3">
                            <div class="font-medium">{{ $m->name }}</div>
                            <div class="text-gray-600">{{ $m->email }}</div>
                        </td>
                        <td class="p-3">
                            {{ $m->subject }}
                        </td>
                        <td class="p-3 text-gray-600">
                            {{ $m->created_at?->format('d/m/Y H:i') }}
                        </td>
                        <td class="p-3">
                            <a class="underline" href="{{ route('admin.contact.show', $m) }}">Open</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-6 text-gray-600">Geen berichten.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $messages->links() }}
    </div>
@endsection

