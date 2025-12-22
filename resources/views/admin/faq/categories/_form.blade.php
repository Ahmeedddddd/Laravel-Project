@php
    /** @var \App\Models\FaqCategory|null $category */
@endphp

<div>
    <label class="block text-sm font-medium mb-1" for="name">Naam</label>
    <input
        id="name"
        name="name"
        type="text"
        required
        value="{{ old('name', $category->name ?? '') }}"
        class="w-full border rounded px-3 py-2"
    />
    @error('name')
        <div class="mt-1 text-sm text-red-700">{{ $message }}</div>
    @enderror
</div>

