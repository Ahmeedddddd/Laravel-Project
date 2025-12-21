<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;

class NewsPublicController extends Controller
{
    public function index(): View
    {
        $items = News::query()
            ->orderByDesc('published_at')
            ->paginate(10);

        return view('news.index', [
            'items' => $items,
        ]);
    }

    public function show(News $news): View
    {
        return view('news.show', [
            'news' => $news,
        ]);
    }
}

