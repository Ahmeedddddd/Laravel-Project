@props([
    'action' => '',
    'q' => '',
    'label' => 'Zoek op username of weergavenaam',
    'placeholder' => 'bv. ahmed of Ahmed B.',
    'inputId' => 'q',
    'resetUrl' => null,
    // Optional: when provided, enables live suggestions (AJAX)
    'suggestUrl' => null,
    'minChars' => 2,
    'suggestLimit' => 6,
])

<div class="card">
    <form method="GET" action="{{ $action }}" class="space-y-3">
        <label for="{{ $inputId }}" class="block text-sm font-medium text-slate-700">{{ $label }}</label>

        <div class="flex flex-col sm:flex-row gap-2">
            <div class="w-full relative" @if($suggestUrl) data-user-search-suggest @endif>
                <input
                    id="{{ $inputId }}"
                    name="q"
                    value="{{ $q }}"
                    placeholder="{{ $placeholder }}"
                    class="w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                    autocomplete="off"
                    @if($suggestUrl)
                        data-user-search-input
                        data-suggest-url="{{ $suggestUrl }}"
                        data-min-chars="{{ (int) $minChars }}"
                        data-limit="{{ (int) $suggestLimit }}"
                    @endif
                />

                @if($suggestUrl)
                    <div
                        data-user-search-panel
                        class="hidden absolute z-20 mt-2 w-full bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm ring-1 ring-black/5 divide-y divide-slate-100"
                    ></div>
                @endif
            </div>

            <button type="submit" class="btn-primary shrink-0">Zoek</button>
        </div>

        @if (($q ?? '') !== '' && $resetUrl)
            <div>
                <a class="text-sm btn-link" href="{{ $resetUrl }}">Reset</a>
            </div>
        @endif
    </form>
</div>

