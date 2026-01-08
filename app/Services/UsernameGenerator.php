<?php

namespace App\Services;

use App\Models\Profile;
use Illuminate\Support\Str;

class UsernameGenerator
{
    /**
     * Generate a unique username based on a preferred base (typically the user's name).
     *
     * Rules:
     * - slug the preferred input (no separators)
     * - fallback to "user" when empty
     * - append an incrementing number when taken (user2, user3, ...)
     */
    public static function uniqueFromPreferred(string $preferred): string
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
}

