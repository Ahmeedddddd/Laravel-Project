<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminNewsController extends Controller
{
    public function index(): View
    {
        $items = News::query()
            ->orderByDesc('published_at')
            ->paginate(15);

        return view('admin.news.index', [
            'items' => $items,
        ]);
    }

    public function create(): View
    {
        return view('admin.news.create');
    }

    public function store(Request $request): RedirectResponse
    {
        // Step 4 will implement validation + upload.
        // For now, just a minimal placeholder to prove routing works.
        return redirect()->route('admin.news.index')->with('success', 'News item (placeholder) opgeslagen.');
    }

    public function edit(News $news): View
    {
        return view('admin.news.edit', [
            'news' => $news,
        ]);
    }

    public function update(Request $request, News $news): RedirectResponse
    {
        // Step 5 will implement validation + image replacement.
        return redirect()->route('admin.news.index')->with('success', 'News item (placeholder) geüpdatet.');
    }

    public function destroy(News $news): RedirectResponse
    {
        // Step 6 will implement delete.
        return redirect()->route('admin.news.index')->with('success', 'News item (placeholder) verwijderd.');
    }
}

