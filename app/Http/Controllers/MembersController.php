<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MembersController extends Controller
{
    /**
     * Public members page (guest) with optional GET search.
     */
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        // Basic guard: keep query reasonable.
        if (mb_strlen($q) > 100) {
            $q = mb_substr($q, 0, 100);
        }

        // Only show real public profiles and never show admins.
        $usersQuery = User::query()
            ->with('profile')
            ->where('is_admin', false)
            ->whereHas('profile', function ($profileQuery) {
                $profileQuery->whereNotNull('username');
            });

        if ($q !== '') {
            $usersQuery->where(function ($query) use ($q) {
                $query
                    ->where('name', 'like', '%' . $q . '%')
                    ->orWhereHas('profile', function ($profileQuery) use ($q) {
                        $profileQuery
                            ->where('username', 'like', '%' . $q . '%')
                            ->orWhere('display_name', 'like', '%' . $q . '%');
                    });
            });
        }

        $users = $usersQuery
            ->orderBy('name')
            ->paginate(12)
            ->appends($request->query());

        // Keep the Blade template stable: it expects items with username/display_name/avatar_url.
        $members = $users->through(function (User $user) {
            $profile = $user->profile;

            return (object) [
                'username' => $profile->username,
                'display_name' => $profile->display_name ?: $user->name,
                'avatar_url' => $profile->avatar_url,
            ];
        });

        return view('public.members', [
            'q' => $q,
            'profiles' => $members,
        ]);
    }
}

