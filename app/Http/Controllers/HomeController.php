<?php

namespace App\Http\Controllers;

use App\Models\News;
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
        $q = (string) $request->query('q', '');

        $profiles = Profile::query()
            ->search($q)
            ->orderBy('username')
            ->paginate(12)
            ->appends($request->query());

        $latestNews = News::query()
            ->whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->select(['id', 'title', 'image_path', 'content', 'published_at'])
            ->limit(3)
            ->get();

        return view('public.home', [
            'q' => trim($q) === '' ? '' : mb_substr(trim($q), 0, 100),
            'profiles' => $profiles,
            'latestNews' => $latestNews,
        ]);
    }
}
