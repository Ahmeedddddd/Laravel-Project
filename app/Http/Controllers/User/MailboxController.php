<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MailboxController extends Controller
{
    public function index(Request $request): View
    {
        $userId = $request->user()->id;

        $messages = ContactMessage::query()
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('account.messages.index', [
            'messages' => $messages,
        ]);
    }

    public function show(Request $request, ContactMessage $message): View
    {
        abort_unless((int) $message->user_id === (int) $request->user()->id, 403);

        return view('account.messages.show', [
            'message' => $message,
        ]);
    }
}
