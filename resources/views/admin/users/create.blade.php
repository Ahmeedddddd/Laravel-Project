@extends('layouts.admin')

@section('title', 'Nieuwe gebruiker')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Nieuwe gebruiker</h1>
        <a href="{{ route('admin.users.index') }}" class="text-sm underline">Terug naar users</a>
    </div>

    <div class="bg-white border rounded p-4 max-w-xl">
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1" for="name">Username</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" class="w-full border rounded px-3 py-2" required>
                @error('name')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1" for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2" required>
                @error('email')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1" for="password">Password</label>
                <input id="password" name="password" type="password" class="w-full border rounded px-3 py-2" required>
                @error('password')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex items-center gap-2">
                <input id="is_admin" name="is_admin" type="checkbox" value="1" class="border rounded" {{ old('is_admin') ? 'checked' : '' }}>
                <label for="is_admin" class="text-sm">Maak admin</label>
            </div>

            <div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Gebruiker aanmaken</button>
            </div>
        </form>
    </div>
@endsection

