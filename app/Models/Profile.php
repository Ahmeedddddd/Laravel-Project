<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'username',
        'display_name',
        'bio',
        'avatar_path',
        'birthday',
    ];

    protected $casts = [
        'birthday' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Return a full URL to the avatar (or null) to keep view code simple.
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar_path) {
            return asset('storage/' . $this->avatar_path);
        }

        return null;
    }

    /**
     * Reusable search scope (public-safe): searches by username or display name.
     */
    public function scopeSearch(Builder $query, ?string $q): Builder
    {
        $q = trim((string) ($q ?? ''));

        if ($q === '') {
            return $query;
        }

        // Basic guard: keep query reasonable.
        if (mb_strlen($q) > 100) {
            $q = mb_substr($q, 0, 100);
        }

        return $query->where(function (Builder $sub) use ($q) {
            $sub
                ->where('username', 'like', '%' . $q . '%')
                ->orWhere('display_name', 'like', '%' . $q . '%');
        });
    }
}
