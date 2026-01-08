@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Admin dashboard</h1>

    <div class="bg-white border rounded p-4">
        <p class="text-gray-700">Welkom, {{ auth()->user()->name }}.</p>
        <p class="text-gray-600 text-sm mt-1">Hier kan je users beheren.</p>

        <div class="mt-4">
            <a href="{{ route('admin.users.index') }}">
                <x-admin-button>
                    Ga naar user management
                </x-admin-button>
            </a>
        </div>
    </div>
@endsection

