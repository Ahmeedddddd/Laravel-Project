@php
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Berichten') }}
        </h2>
    </x-slot>

    <div class="bg-white border border-slate-200 rounded-lg">
        <div class="p-4 border-b border-slate-100">
            <p class="text-sm text-slate-600">Je contact-berichten en antwoorden van de admin.</p>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($messages as $m)
                <a href="{{ route('account.messages.show', $m) }}" class="block p-4 hover:bg-emerald-50/60">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <div class="font-medium text-slate-900 truncate">{{ $m->subject }}</div>
                            <div class="text-sm text-slate-600 truncate">{{ Str::limit($m->message, 80) }}</div>
                        </div>
                        <div class="text-xs text-slate-500 whitespace-nowrap">
                            {{ $m->created_at?->format('d/m/Y') }}
                        </div>
                    </div>

                    <div class="mt-2">
                        @if($m->replied_at)
                            <span class="text-xs px-2 py-1 rounded bg-emerald-50 text-emerald-700">Beantwoord</span>
                        @else
                            <span class="text-xs px-2 py-1 rounded bg-slate-100 text-slate-700">In behandeling</span>
                        @endif
                    </div>
                </a>
            @empty
                <div class="p-6 text-sm text-slate-600">Je hebt nog geen berichten.</div>
            @endforelse
        </div>
    </div>

    <div class="mt-4">
        {{ $messages->links() }}
    </div>
</x-app-layout>
