@php
    /** @var \App\Models\FaqItem|null $item */
    /** @var \Illuminate\Support\Collection<int, \App\Models\FaqCategory> $categories */
@endphp

<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium mb-1" for="faq_category_id">Categorie</label>
        <select id="faq_category_id" name="faq_category_id" class="w-full border rounded px-3 py-2" required>
            <option value="">-- Kies een categorie --</option>
            @foreach ($categories as $category)
                <option
                    value="{{ $category->id }}"
                    @selected(old('faq_category_id', $item->faq_category_id ?? '') == $category->id)
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('faq_category_id')
            <div class="mt-1 text-sm text-red-700">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1" for="question">Vraag</label>
        <input
            id="question"
            name="question"
            type="text"
            required
            value="{{ old('question', $item->question ?? '') }}"
            class="w-full border rounded px-3 py-2"
        />
        @error('question')
            <div class="mt-1 text-sm text-red-700">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1" for="answer">Antwoord</label>
        <textarea
            id="answer"
            name="answer"
            rows="6"
            required
            class="w-full border rounded px-3 py-2"
        >{{ old('answer', $item->answer ?? '') }}</textarea>
        @error('answer')
            <div class="mt-1 text-sm text-red-700">{{ $message }}</div>
        @enderror
    </div>
</div>

