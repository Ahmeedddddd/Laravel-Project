@extends('layouts.admin')

@section('title', 'Contact bericht')

@section('content')
    <a href="{{ route('admin.contact.index') }}" class="text-sm underline">&larr; Terug</a>

    <div class="mt-4 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white border rounded p-4">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h1 class="text-xl font-bold">{{ $message->subject }}</h1>
                        <p class="text-sm text-gray-600 mt-1">Van {{ $message->name }} ({{ $message->email }})</p>
                    </div>
                    <div class="text-xs text-gray-600">
                        {{ $message->created_at?->format('d/m/Y H:i') }}
                    </div>
                </div>

                <div class="mt-4 whitespace-pre-wrap text-gray-800">{{ $message->message }}</div>
            </div>

            <div class="mt-6 bg-white border rounded p-4">
                <h2 class="font-semibold">Antwoord</h2>

                @if($message->replied_at)
                    <p class="text-sm text-emerald-700 mt-1">Beantwoord op {{ $message->replied_at->format('d/m/Y H:i') }}</p>
                @endif

                <form method="POST" action="{{ route('admin.contact.reply', $message) }}" class="mt-3 space-y-3">
                    @csrf
                    <textarea name="admin_reply" rows="6" class="w-full border rounded p-2" placeholder="Typ je antwoord...">{{ old('admin_reply', $message->admin_reply) }}</textarea>
                    @error('admin_reply')
                        <div class="text-sm text-red-700">{{ $message }}</div>
                    @enderror
                    <x-admin-button type="submit">Opslaan</x-admin-button>
                </form>
            </div>
        </div>

        <aside class="lg:col-span-1">
            <div class="bg-white border rounded p-4">
                <h3 class="font-semibold">Status</h3>
                <ul class="mt-2 text-sm text-gray-700 space-y-1">
                    <li><span class="text-gray-500">Nieuw:</span> {{ $message->read_at ? 'nee' : 'ja' }}</li>
                    <li><span class="text-gray-500">Gelezen:</span> {{ $message->read_at ? $message->read_at->format('d/m/Y H:i') : 'nee' }}</li>
                    <li><span class="text-gray-500">Beantwoord:</span> {{ $message->replied_at ? $message->replied_at->format('d/m/Y H:i') : 'nee' }}</li>
                </ul>
            </div>
        </aside>
    </div>
@endsection

