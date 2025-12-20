<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->orderByDesc('is_admin')
            ->orderBy('name')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // username
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            // email
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            // password
            'password' => ['required', 'string'],
            // checkbox
            'is_admin' => ['nullable', 'boolean'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => (bool)($validated['is_admin'] ?? false),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Gebruiker aangemaakt.');
    }

    public function toggleAdmin(User $user): RedirectResponse
    {
        // Prevent locking yourself out by removing your own admin rights
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Je kan je eigen adminrechten niet aanpassen.');
        }

        $user->update(['is_admin' => ! (bool) $user->is_admin]);

        $role = $user->is_admin ? 'admin' : 'user';

        return back()->with('success', "Rol aangepast: {$user->name} is nu {$role}.");
    }

    // Backwards compatible methods
    public function makeAdmin(User $user): RedirectResponse
    {
        $user->update(['is_admin' => true]);

        return back()->with('success', "{$user->name} is nu admin.");
    }

    public function revokeAdmin(User $user): RedirectResponse
    {
        $user->update(['is_admin' => false]);

        return back()->with('success', "Adminrechten verwijderd voor {$user->name}.");
    }
}
