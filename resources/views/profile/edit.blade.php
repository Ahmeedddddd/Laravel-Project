<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mijn Profiel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="mb-4 text-green-600">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Gebruikersnaam (voor de URL):</label>
                        <input
                            type="text"
                            name="username"
                            value="{{ old('username', $profile->username) }}"
                            class="mt-1 block w-full rounded-lg border-gray-300"
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Weergavenaam:</label>
                        <input
                            type="text"
                            name="display_name"
                            value="{{ old('display_name', $profile->display_name) }}"
                            class="mt-1 block w-full rounded-lg border-gray-300"
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Bio:</label>
                        <textarea
                            name="bio"
                            class="mt-1 block w-full rounded-lg border-gray-300"
                        >{{ old('bio', $profile->bio) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Profielfoto:</label>

                        @if($profile->avatar_path)
                            <img
                                src="{{ asset('storage/' . $profile->avatar_path) }}"
                                width="100"
                                class="mb-2 rounded"
                            >
                        @endif

                        <input
                            type="file"
                            name="avatar"
                            class="mt-1 block w-full"
                        >
                    </div>

                    <button
                        type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                    >
                        Opslaan
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
    
