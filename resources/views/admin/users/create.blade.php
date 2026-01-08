@extends('layouts.admin')

@section('title', 'Nieuwe gebruiker')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Nieuwe gebruiker</h1>
        <a href="{{ route('admin.users.index') }}" class="text-sm text-slate-600 hover:text-emerald-700 underline underline-offset-4">Terug naar users</a>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl p-6 max-w-xl shadow-sm">
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1" for="name">Username</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" class="w-full border border-slate-200 rounded-lg px-3 py-2 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                @error('name')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1" for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" class="w-full border border-slate-200 rounded-lg px-3 py-2 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                @error('email')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1" for="password">Password</label>
                <input id="password" name="password" type="password" class="w-full border border-slate-200 rounded-lg px-3 py-2 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                @error('password')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex items-center gap-2">
                <input id="is_admin" name="is_admin" type="checkbox" value="1" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" {{ old('is_admin') ? 'checked' : '' }}>
                <label for="is_admin" class="text-sm text-slate-700">Maak admin</label>
            </div>

            <div class="pt-2">
                <x-admin-button type="submit">Gebruiker aanmaken</x-admin-button>
            </div>
        </form>
    </div>
@endsection
