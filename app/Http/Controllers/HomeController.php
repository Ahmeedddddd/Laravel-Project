<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Public homepage.
     */
    public function index(): View
    {
        $latestNews = News::query()
            ->whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->select(['id', 'title', 'image_path', 'content', 'published_at'])
            ->limit(3)
            ->get();

        return view('public.home', [
            'latestNews' => $latestNews,
        ]);
    }
}
