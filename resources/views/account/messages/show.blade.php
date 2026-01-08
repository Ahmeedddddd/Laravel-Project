<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Bericht') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <div>
            <a class="btn-link" href="{{ route('account.messages.index') }}">&larr; Terug naar berichten</a>
        </div>

        <div class="bg-white border border-slate-200 rounded-lg p-6">
            <h1 class="text-xl font-semibold text-slate-900">{{ $message->subject }}</h1>
            <p class="text-sm text-slate-600 mt-1">Verzonden op {{ $message->created_at?->format('d/m/Y H:i') }}</p>

            <div class="mt-4 whitespace-pre-wrap text-slate-800">{{ $message->message }}</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-lg p-6">
            <h2 class="text-lg font-semibold text-slate-900">Antwoord van admin</h2>

            @if($message->replied_at)
                <p class="text-sm text-emerald-700 mt-1">Beantwoord op {{ $message->replied_at->format('d/m/Y H:i') }}</p>
                <div class="mt-4 whitespace-pre-wrap text-slate-800">{{ $message->admin_reply }}</div>
            @else
                <p class="text-sm text-slate-600 mt-1">Nog geen antwoord. Je bericht is ontvangen.</p>
            @endif
        </div>
    </div>
</x-app-layout>

