<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminFaqCategoryController extends Controller
{
    public function index(): View
    {
        $categories = FaqCategory::query()
            ->withCount('items')
            ->orderBy('name')
            ->get();

        return view('admin.faq.categories.index', [
            'categories' => $categories,
        ]);
    }

    public function create(): View
    {
        return view('admin.faq.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        FaqCategory::create([
            'name' => $validated['name'],
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'FAQ categorie aangemaakt.');
    }

    public function edit(FaqCategory $category): View
    {
        return view('admin.faq.categories.edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, FaqCategory $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $category->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'FAQ categorie bijgewerkt.');
    }

    public function destroy(FaqCategory $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'FAQ categorie verwijderd.');
    }
}
