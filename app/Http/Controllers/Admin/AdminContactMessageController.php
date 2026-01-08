<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $messages = ContactMessage::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($q2) use ($q) {
                    $q2->where('subject', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('name', 'like', "%{$q}%")
                        ->orWhere('message', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(15)
            ->appends($request->query());

        return view('admin.contact.index', [
            'messages' => $messages,
            'q' => $q,
        ]);
    }

    public function show(ContactMessage $message): View
    {
        if (! $message->read_at) {
            $message->forceFill(['read_at' => now()])->save();
        }

        return view('admin.contact.show', [
            'message' => $message,
        ]);
    }

    public function reply(Request $request, ContactMessage $message): RedirectResponse
    {
        $validated = $request->validate([
            'admin_reply' => ['required', 'string'],
        ]);

        $message->forceFill([
            'admin_reply' => $validated['admin_reply'],
            'replied_at' => now(),
        ])->save();

        return redirect()
            ->route('admin.contact.show', $message)
            ->with('success', 'Antwoord opgeslagen.');
    }
}

