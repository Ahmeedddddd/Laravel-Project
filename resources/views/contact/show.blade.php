<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Contact') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="mb-4 p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-900">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-lg p-6">
        <form method="POST" action="{{ route('contact.submit') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700" for="name">Naam</label>
                <input id="name" name="name" type="text" required value="{{ $prefillName ?? old('name') }}" class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2" />
                @error('name')
                    <div class="mt-1 text-sm text-red-700">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700" for="email">E-mail</label>
                <input id="email" name="email" type="email" required value="{{ $prefillEmail ?? old('email') }}" class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2" />
                @error('email')
                    <div class="mt-1 text-sm text-red-700">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700" for="subject">Onderwerp</label>
                <input id="subject" name="subject" type="text" required value="{{ old('subject') }}" class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2" />
                @error('subject')
                    <div class="mt-1 text-sm text-red-700">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700" for="message">Bericht</label>
                <textarea id="message" name="message" rows="6" required class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2">{{ old('message') }}</textarea>
                @error('message')
                    <div class="mt-1 text-sm text-red-700">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-700 text-white rounded-lg hover:bg-emerald-800">
                Versturen
            </button>
        </form>
    </div>
</x-app-layout>

