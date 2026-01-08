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

    {{-- Search Bar --}}
    <div class="mb-6">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-2">
            <div class="flex-1 relative">
                <input
                    type="search"
                    name="search"
                    value="{{ $search ?? '' }}"
                    placeholder="Zoek op naam of email..."
                    class="w-full px-4 py-2.5 pl-10 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                >
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <button
                type="submit"
                class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition font-medium"
            >
                Zoeken
            </button>
            @if($search ?? false)
                <a
                    href="{{ route('admin.users.index') }}"
                    class="px-4 py-2.5 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition font-medium"
                >
                    Reset
                </a>
            @endif
        </form>

        @if($search ?? false)
            <p class="mt-2 text-sm text-slate-600">
                Zoekresultaten voor: <strong class="text-slate-900">"{{ $search }}"</strong>
                <span class="text-slate-500">({{ count($users) }} {{ count($users) === 1 ? 'resultaat' : 'resultaten' }})</span>
            </p>
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
                @forelse($users as $user)
                    <tr class="border-t border-slate-100 hover:bg-slate-50/70">
                        <td class="p-3">{{ $user->name }}</td>
                        <td class="p-3">{{ $user->email }}</td>
                        <td class="p-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs {{ $user->is_admin ? 'bg-emerald-50 text-emerald-800' : 'bg-slate-50 text-slate-700' }}">
                                {{ $user->is_admin ? 'Admin' : 'User' }}
                            </span>
                        </td>
                        <td class="p-3">
                            <div class="flex items-center gap-3 flex-wrap">
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

                                @php
                                    $canDelete = auth()->id() !== $user->id && ! $user->is_admin;
                                @endphp

                                @if($canDelete)
                                    <form
                                        method="POST"
                                        action="{{ route('admin.users.destroy', $user) }}"
                                        class="inline"
                                        onsubmit="return confirm('Ben je zeker dat je deze gebruiker wil verwijderen? Dit kan niet ongedaan gemaakt worden.');"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-lg shadow-sm bg-rose-600 text-white hover:bg-rose-700 transition">
                                            Verwijderen
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-400 cursor-not-allowed" title="Je kan jezelf of admins niet verwijderen" disabled>
                                        Verwijderen
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-6 text-center text-slate-500">
                            @if($search ?? false)
                                Geen gebruikers gevonden voor "{{ $search }}"
                            @else
                                Geen gebruikers beschikbaar
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
