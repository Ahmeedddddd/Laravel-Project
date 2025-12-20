@extends('layouts.admin')

@section('title', 'User management')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Users</h1>

        {{-- Only admins can reach this page anyway, but keeping it explicit/readable --}}
        @if(auth()->user()?->is_admin)
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-lg shadow-sm hover:bg-emerald-700 transition">
                <span class="text-lg leading-none">+</span>
                <span>Nieuwe gebruiker</span>
            </a>
        @endif
    </div>

    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-emerald-50">
                <tr>
                    <th class="text-left p-3 font-semibold text-slate-700">Username</th>
                    <th class="text-left p-3 font-semibold text-slate-700">Email</th>
                    <th class="text-left p-3 font-semibold text-slate-700">Rol</th>
                    <th class="text-left p-3 font-semibold text-slate-700">Actie</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="border-t border-slate-100 hover:bg-slate-50/70">
                        <td class="p-3">{{ $user->name }}</td>
                        <td class="p-3">{{ $user->email }}</td>
                        <td class="p-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs {{ $user->is_admin ? 'bg-emerald-50 text-emerald-800' : 'bg-slate-50 text-slate-700' }}">
                                {{ $user->is_admin ? 'Admin' : 'User' }}
                            </span>
                        </td>
                        <td class="p-3">
                            @if($user->is_admin)
                                <span class="mr-2 text-slate-600">Actie: adminrechten afnemen</span>
                            @else
                                <span class="mr-2 text-slate-600">Actie: admin maken</span>
                            @endif

                            <form method="POST" action="{{ route('admin.users.toggleAdmin', $user) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-3 py-1.5 rounded-lg shadow-sm {{ $user->is_admin ? 'bg-slate-100 text-slate-800 hover:bg-slate-200' : 'bg-emerald-600 text-white hover:bg-emerald-700' }} transition">
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
