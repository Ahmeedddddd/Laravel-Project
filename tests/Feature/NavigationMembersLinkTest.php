<?php

use App\Models\User;

it('shows Members link in navbar for guests and authenticated users', function () {
    // Guest
    $this->get('/')
        ->assertOk()
        ->assertSee('Members');

    // Authenticated
    $user = User::factory()->create();
    $this->actingAs($user)
        ->get('/dashboard')
        ->assertOk()
        ->assertSee('Members');
});

