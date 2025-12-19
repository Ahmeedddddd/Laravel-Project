<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\ImageManagerStatic as Image;

class ProfileController extends Controller
{
    /**
     * Display the public profile by username.
     */
    public function show($username): View
    {
        $profile = Profile::where('username', $username)->firstOrFail();

        return view('profile.show', compact('profile'));
    }

    /**
     * Create a unique username based on a preferred base.
     */
    private function generateUniqueUsername(string $preferred): string
    {
        $base = Str::slug($preferred, '');
        $base = $base !== '' ? strtolower($base) : 'user';

        $username = $base;
        $i = 2;

        while (Profile::where('username', $username)->exists()) {
            $username = $base . $i;
            $i++;
        }

        return $username;
    }

    /**
     * Get or create the authenticated user's profile.
     */
    private function getOrCreateProfileForUser(\App\Models\User $user): Profile
    {
        $profile = $user->profile;
        if ($profile) {
            return $profile;
        }

        $username = $this->generateUniqueUsername($user->name);

        return $user->profile()->create([
            'user_id' => $user->id,
            'username' => $username,
        ]);
    }

    /**
     * Show form to edit the authenticated user's profile.
     */
    public function edit(): View
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (! $user) {
            abort(403);
        }

        $profile = $this->getOrCreateProfileForUser($user);

        $this->authorize('update', $profile);

        return view('profile.edit', compact('profile'));
    }

    /** Update the user's profile information. */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (! $user) {
            abort(403);
        }

        $profile = $this->getOrCreateProfileForUser($user);

        $this->authorize('update', $profile);

        $data = $request->only(['username', 'display_name', 'bio', 'birthday']);

        // Avatar upload handling with server-side resize
        if ($request->hasFile('avatar')) {
            // delete old avatar if exists (main + thumb)
            if ($profile->avatar_path && Storage::disk('public')->exists($profile->avatar_path)) {
                // delete main
                Storage::disk('public')->delete($profile->avatar_path);
                // delete thumb (same filename under avatars/thumbs)
                $thumbPath = preg_replace('#^avatars/#', 'avatars/thumbs/', $profile->avatar_path);
                if (Storage::disk('public')->exists($thumbPath)) {
                    Storage::disk('public')->delete($thumbPath);
                }
            }

            $file = $request->file('avatar');
            $ext = 'jpg';
            $filename = Str::random(20) . '.' . $ext;
            $mainPath = 'avatars/' . $filename;
            $thumbPath = 'avatars/thumbs/' . $filename;

            try {
                if (class_exists(Image::class)) {
                    // create main 400x400
                    $img = Image::make($file)->fit(400, 400)->encode($ext, 85);
                    Storage::disk('public')->put($mainPath, (string) $img);

                    // create thumb 128x128
                    $thumb = Image::make($file)->fit(128, 128)->encode($ext, 85);
                    Storage::disk('public')->put($thumbPath, (string) $thumb);
                } else {
                    // fallback: store original
                    $path = $file->store('avatars', 'public');
                    $mainPath = $path;
                    // no thumb
                }
            } catch (\Exception $e) {
                // on any error, fallback to default store
                $path = $file->store('avatars', 'public');
                $mainPath = $path;
            }

            $data['avatar_path'] = $mainPath;
        }

        $profile->fill($data);
        $profile->save();

        return Redirect::route('profile.edit')->with('success', 'Profiel opgeslagen.');
    }
}
