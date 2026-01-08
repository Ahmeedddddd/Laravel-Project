<?php

use App\Models\Profile;
use App\Models\User;

it('does not show admin users on the members page', function () {
    $admin = User::factory()->create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'is_admin' => true,
    ]);

    $admin->profile()->create([
        'username' => 'admin',
        'display_name' => 'Admin',
    ]);

    $user = User::factory()->create([
        'name' => 'Medo',
        'email' => 'ahmed@gmail.com',
        'is_admin' => false,
    ]);

    $user->profile()->create([
        'username' => 'medo',
        'display_name' => 'Medo',
    ]);

    $this->get('/members?q=medo')
        ->assertOk()
        ->assertSee('Medo')
        ->assertDontSee('@admin');
});

it('links to the public profile by username', function () {
    $user = User::factory()->create([
        'name' => 'Medo',
        'is_admin' => false,
    ]);

    $user->profile()->create([
        'username' => 'medo',
        'display_name' => 'Medo',
    ]);

    $this->get('/members?q=medo')
        ->assertOk()
        ->assertSee(route('public.users.show', ['username' => 'medo']), false);

    $this->get('/users/medo')->assertOk()->assertSee('Medo');
});

