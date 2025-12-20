<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\View\View;

class PublicProfileController extends Controller
{
    /**
     * Public, read-only profile page.
     */
    public function show(string $username): View
    {
        $profile = Profile::where('username', $username)->firstOrFail();

        return view('public.user-show', [
            'profile' => $profile,
        ]);
    }
}

