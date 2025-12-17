<?php

namespace App\Models;

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
}
