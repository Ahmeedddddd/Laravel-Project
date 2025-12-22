<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use App\Models\FaqItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminFaqItemController extends Controller
{
    public function index(): View
    {
        $items = FaqItem::query()
            ->with('category')
            ->orderByDesc('id')
            ->get();

        return view('admin.faq.items.index', [
            'items' => $items,
        ]);
    }

    public function create(): View
    {
        $categories = FaqCategory::query()->orderBy('name')->get();

        return view('admin.faq.items.create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'faq_category_id' => ['required', 'integer', 'exists:faq_categories,id'],
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
        ]);

        FaqItem::create($validated);

        return redirect()->route('admin.items.index')->with('success', 'FAQ vraag aangemaakt.');
    }

    public function edit(FaqItem $item): View
    {
        $categories = FaqCategory::query()->orderBy('name')->get();

        return view('admin.faq.items.edit', [
            'item' => $item,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, FaqItem $item): RedirectResponse
    {
        $validated = $request->validate([
            'faq_category_id' => ['required', 'integer', 'exists:faq_categories,id'],
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
        ]);

        $item->update($validated);

        return redirect()->route('admin.items.index')->with('success', 'FAQ vraag bijgewerkt.');
    }

    public function destroy(FaqItem $item): RedirectResponse
    {
        $item->delete();

        return redirect()->route('admin.items.index')->with('success', 'FAQ vraag verwijderd.');
    }
}

