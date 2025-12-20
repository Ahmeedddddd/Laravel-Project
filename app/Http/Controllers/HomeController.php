<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Public homepage (guest) with optional GET search.
     */
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        // Basic guard: keep query reasonable.
        if (mb_strlen($q) > 100) {
            $q = mb_substr($q, 0, 100);
        }

        $profilesQuery = Profile::query();

        if ($q !== '') {
            $profilesQuery->where(function ($query) use ($q) {
                $query
                    ->where('username', 'like', '%' . $q . '%')
                    ->orWhere('display_name', 'like', '%' . $q . '%');
            });
        }

        $profiles = $profilesQuery
            ->orderBy('username')
            ->paginate(12)
            ->appends($request->query());

        return view('public.home', [
            'q' => $q,
            'profiles' => $profiles,
        ]);
    }
}

