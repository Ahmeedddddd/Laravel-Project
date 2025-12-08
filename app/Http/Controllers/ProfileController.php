<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show($username)
    {
        $profile = Profile::where('username', $username)->firstOrFail();

        return view('profile.show', compact('profile'));
    }

    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile()->firstOrCreate(
            ['user_id' => $user->id],
            ['username' => strtolower(str_replace(' ', '', $user->name))]
        );

        return view('profile.edit', compact('profile'));
    }


/* Update the user's profile information.*/

    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        $request->validate([
            'username' => 'required|min:3|max:50|unique:profiles,username,' . $profile->id,
            'display_name' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $profile->username = $request->username;
        $profile->display_name = $request->display_name;
        $profile->bio = $request->bio;

        // Avatar upload
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $profile->avatar_path = $path;
        }

        $profile->save();

        return redirect()->route('profile.edit')->with('success', 'Profiel bijgewerkt!');
    }
}
