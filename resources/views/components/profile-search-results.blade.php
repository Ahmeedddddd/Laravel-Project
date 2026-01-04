@props([
    /** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $profiles */
    'profiles' => null,
    'totalLabel' => 'Gebruikers',
])

<div>
    <div class="flex items-center justify-between gap-4">
        <h2 class="text-lg font-semibold text-slate-900">{{ $totalLabel }}</h2>
        <p class="text-xs text-slate-500">
            {{ ($profiles?->total() ?? 0) }} resultaat{{ ($profiles?->total() ?? 0) === 1 ? '' : 'en' }}
        </p>
    </div>

    @if (!$profiles || $profiles->count() === 0)
        <div class="mt-4 card text-sm text-slate-600">
            Geen gebruikers gevonden.
        </div>
    @else
        <div class="mt-4 bg-white border border-slate-200 rounded-2xl divide-y divide-slate-100 overflow-hidden shadow-sm ring-1 ring-black/5">
            @foreach ($profiles as $profile)
                <a
                    href="{{ route('public.users.show', ['username' => $profile->username]) }}"
                    class="flex items-center gap-3 p-4 hover:bg-emerald-50/60 focus:bg-emerald-50/60 focus:outline-none"
                >
                    @if ($profile->avatar_url)
                        <img
                            src="{{ $profile->avatar_url }}"
                            alt="Profielfoto van {{ $profile->username }}"
                            class="w-10 h-10 rounded-full object-cover border border-slate-200"
                            loading="lazy"
                        />
                    @else
                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 font-semibold">
                            {{ strtoupper(mb_substr($profile->username ?? 'U', 0, 1)) }}
                        </div>
                    @endif

                    <div class="min-w-0 flex-1">
                        <div class="font-medium truncate text-slate-900">{{ $profile->display_name ?: $profile->username }}</div>
                        <div class="text-sm text-slate-600 truncate">{{ '@' . $profile->username }}</div>
                    </div>

                    <div class="text-xs text-emerald-700 font-medium">Bekijk &rarr;</div>
                </a>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $profiles->links() }}
        </div>
    @endif
</div>

