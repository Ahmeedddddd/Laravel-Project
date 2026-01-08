<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        return view('contact.show', [
            'prefillName' => old('name', $user?->name ?? ''),
            'prefillEmail' => old('email', $user?->email ?? ''),
        ]);
    }

    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        ContactMessage::create([
            'user_id' => auth()->id(),
            ...$validated,
        ]);

        return redirect()
            ->route('contact.show')
            ->with('success', 'Bedankt! Je bericht is goed ontvangen.');
    }
}
