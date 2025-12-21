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
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'published_at' => ['required', 'date'],
            'image' => ['nullable', 'image', 'max:4096'], // 4MB
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
        }

        News::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'published_at' => $validated['published_at'],
            'image_path' => $imagePath,
            'created_by' => $request->user()?->id,
        ]);

        return redirect()->route('admin.news.index')->with('success', 'Nieuwsitem aangemaakt.');
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
