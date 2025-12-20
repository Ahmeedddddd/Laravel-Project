@extends('layouts.admin')

@section('title', 'User management')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Users</h1>

        {{-- Only admins can reach this page anyway, but keeping it explicit/readable --}}
        @if(auth()->user()?->is_admin)
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded">
                <span class="text-lg leading-none">+</span>
                <span>Nieuwe gebruiker</span>
            </a>
        @endif
    </div>

    <div class="bg-white border rounded overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left p-3">Username</th>
                    <th class="text-left p-3">Email</th>
                    <th class="text-left p-3">Rol</th>
                    <th class="text-left p-3">Actie</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="border-t">
                        <td class="p-3">{{ $user->name }}</td>
                        <td class="p-3">{{ $user->email }}</td>
                        <td class="p-3">
                            {{ $user->is_admin ? 'Admin' : 'User' }}
                        </td>
                        <td class="p-3">
                            @if($user->is_admin)
                                <span class="mr-2 text-gray-700">Actie: adminrechten afnemen</span>
                            @else
                                <span class="mr-2 text-gray-700">Actie: admin maken</span>
                            @endif

                            <form method="POST" action="{{ route('admin.users.toggleAdmin', $user) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-3 py-1 rounded {{ $user->is_admin ? 'bg-gray-200' : 'bg-blue-600 text-white' }}">
                                    {{-- Explicit action label (what will happen when you click) --}}
                                    @if($user->is_admin)
                                        Admin afnemen
                                    @else
                                        Admin maken
                                    @endif
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
