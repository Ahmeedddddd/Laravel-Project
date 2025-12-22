<?php

namespace App\Http\Controllers;

use App\Models\FaqCategory;
use Illuminate\View\View;

class FaqPublicController extends Controller
{
    public function index(): View
    {
        $categories = FaqCategory::query()
            ->with(['items' => function ($query) {
                $query->orderBy('id');
            }])
            ->orderBy('name')
            ->get();

        return view('faq.index', [
            'categories' => $categories,
        ]);
    }
}

