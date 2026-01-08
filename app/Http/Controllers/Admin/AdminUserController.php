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
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('is_admin')
            ->orderBy('name')
            ->get();

        return view('admin.users.index', compact('users', 'search'));
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

    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        // Extra safety (policy already blocks, but keep a friendly message)
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Je kan je eigen account niet verwijderen.');
        }

        if ($user->is_admin) {
            return redirect()->route('admin.users.index')->with('error', 'Je kan geen admin account verwijderen.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Gebruiker verwijderd.');
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
