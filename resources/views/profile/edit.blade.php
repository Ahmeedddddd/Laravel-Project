{{-- profile.edit view restored to full version. --}}

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto bg-white shadow rounded p-6">
        <h2 class="text-xl font-bold mb-6">Mijn Profiel</h2>

        @if(session('success'))
            <div class="mb-4 text-green-700">{{ session('success') }}</div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="flex flex-col md:flex-row md:items-start md:space-x-8">
                <!-- Left column: avatar + file input -->
                <div class="md:w-40 w-full mb-6 md:mb-0 flex-shrink-0">
                    <div class="flex items-center md:flex-col md:items-start">
                        <div class="w-24 h-24 md:w-32 md:h-32 rounded-full overflow-hidden bg-gray-100 mr-4 md:mr-0 md:mb-3" style="width:96px; height:96px; border-radius:50%; overflow:hidden;">
                            {{-- Always render an <img> so JS can update its src for preview. If there's no avatar, the img is hidden by CSS. --}}
                            <img id="avatarPreview" src="{{ $profile->avatar_url ?? '' }}" alt="avatar preview" class="w-full h-full object-cover" style="display: {{ $profile->avatar_url ? 'block' : 'none' }}; width:100%; height:100%; object-fit:cover;" />
                            @unless ($profile->avatar_url)
                                <div id="avatarFallback" class="w-full h-full flex items-center justify-center text-gray-500">
                                    <span class="text-xl font-semibold">{{ strtoupper(substr($profile->display_name ?? $profile->username, 0, 1)) }}</span>
                                </div>
                            @endunless
                        </div>

                        <div class="flex-1 md:flex-none">
                            <label class="block text-sm text-gray-700 mb-1">Profielfoto</label>

                            {{-- visible input so browser default file dialog and filename work; we keep custom label optional --}}
                            <input id="avatarInput" type="file" name="avatar" accept="image/*" class="mt-2 block" />
                            @error('avatar')<div class="text-red-600 text-sm mt-2">{{ $message }}</div>@enderror

                            @if($profile->avatar_path)
                                <div id="currentAvatarPath" class="text-xs text-gray-500 mt-3">Huidige: {{ $profile->avatar_path }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right column: form fields -->
                <div class="flex-1">
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm text-gray-700">Gebruikersnaam (voor de URL):</label>
                            <input type="text" name="username" value="{{ old('username', $profile->username) }}" class="w-full border rounded px-3 py-2" />
                            @error('username')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700">Weergavenaam:</label>
                            <input type="text" name="display_name" value="{{ old('display_name', $profile->display_name) }}" class="w-full border rounded px-3 py-2" />
                            @error('display_name')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700">Geboortedatum:</label>
                            <input type="date" name="birthday" value="{{ old('birthday', optional($profile->birthday)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2" />
                            @error('birthday')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700">Over mij:</label>
                            <textarea name="bio" rows="5" class="w-full border rounded px-3 py-2">{{ old('bio', $profile->bio) }}</textarea>
                            @error('bio')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <button id="primarySave" type="submit" class="px-6 py-2 bg-blue-600 text-white rounded">Opslaan</button>
                        <!-- Fallback visible save button fixed to bottom-right in case layout hides the primary button -->
                        <button type="submit" formmethod="post" formaction="{{ route('profile.update') }}" style="position:fixed; right:20px; bottom:20px; z-index:9999; background:#2563eb; color:white; padding:10px 16px; border-radius:6px; border:none; box-shadow:0 4px 14px rgba(0,0,0,0.1);">Opslaan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Inline JS to preview selected avatar file. Uses URL.createObjectURL for fast preview and cleans up object URL. --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('avatarInput');
    const img = document.getElementById('avatarPreview');
    const fallback = document.getElementById('avatarFallback');

    if (!input || !img) return;

    let objectUrl;
    // store original src immediately if present
    if (!img.dataset.original) {
        img.dataset.original = img.src || '';
    }

    input.addEventListener('change', function (e) {
        const file = e.target.files && e.target.files[0];
        if (!file) {
            // if user clears selection, revert to fallback or original url
            if (img.dataset.original) {
                img.src = img.dataset.original;
                if (img.src) {
                    img.style.display = 'block';
                    if (fallback) fallback.style.display = 'none';
                } else {
                    img.style.display = 'none';
                    if (fallback) fallback.style.display = 'flex';
                }
            } else {
                img.style.display = 'none';
                if (fallback) fallback.style.display = 'flex';
            }
            // revoke previous object url if any
            if (objectUrl) { URL.revokeObjectURL(objectUrl); objectUrl = null; }
            return;
        }

        // revoke previous
        if (objectUrl) { URL.revokeObjectURL(objectUrl); objectUrl = null; }
        // create and assign new object url for preview
        objectUrl = URL.createObjectURL(file);
        img.src = objectUrl;
        img.style.display = 'block';
        if (fallback) fallback.style.display = 'none';
    });

    // revoke objectUrl on page unload to free memory
    window.addEventListener('beforeunload', function () {
        if (objectUrl) URL.revokeObjectURL(objectUrl);
    });
});
</script>
@endsection
