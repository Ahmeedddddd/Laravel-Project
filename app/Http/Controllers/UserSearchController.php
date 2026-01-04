<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserSearchController extends Controller
{
    /**
     * Auth-only user search page (public profile results).
     */
    public function index(Request $request): View
    {
        $q = (string) $request->query('q', '');

        $profiles = Profile::query()
            ->search($q)
            ->orderBy('username')
            ->paginate(12)
            ->appends($request->query());

        return view('users.search', [
            'q' => trim($q) === '' ? '' : mb_substr(trim($q), 0, 100),
            'profiles' => $profiles,
        ]);
    }

    /**
     * Auth-only live suggestions (AJAX).
     * Returns only public-safe fields.
     */
    public function suggest(Request $request): JsonResponse
    {
        $q = trim((string) $request->query('q', ''));
        $limit = (int) $request->query('limit', 6);

        $limit = max(1, min($limit, 10));

        if (mb_strlen($q) < 2) {
            return response()->json(['items' => []]);
        }

        if (mb_strlen($q) > 100) {
            $q = mb_substr($q, 0, 100);
        }

        $items = Profile::query()
            ->search($q)
            ->orderBy('username')
            ->limit($limit)
            ->get(['username', 'display_name', 'avatar_path'])
            ->map(fn (Profile $p) => [
                'username' => $p->username,
                'display_name' => $p->display_name,
                'avatar_url' => $p->avatar_url,
                'url' => route('public.users.show', ['username' => $p->username]),
            ])
            ->values();

        return response()->json(['items' => $items]);
    }
}
