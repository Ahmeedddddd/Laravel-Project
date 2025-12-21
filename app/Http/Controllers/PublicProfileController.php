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
        $profile = Profile::whereRaw('lower(username) = ?', [mb_strtolower($username)])->firstOrFail();

        return view('public.user-show', [
            'profile' => $profile,
        ]);
    }
}
