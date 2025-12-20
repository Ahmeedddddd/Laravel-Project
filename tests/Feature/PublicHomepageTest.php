<?php

use App\Models\Profile;
use App\Models\User;

it('shows public homepage without auth', function () {
    $response = $this->get('/');

    $response->assertOk();
    $response->assertSee('Zoek gebruikers');
});

it('filters users by username and display name via GET q parameter', function () {
    $user1 = User::factory()->create(['name' => 'Alice']);
    $user2 = User::factory()->create(['name' => 'Bob']);

    $profile1 = Profile::create([
        'user_id' => $user1->id,
        'username' => 'alice',
        'display_name' => 'Alice Wonderland',
    ]);

    $profile2 = Profile::create([
        'user_id' => $user2->id,
        'username' => 'bob',
        'display_name' => 'Bobby',
    ]);

    $this->get('/?q=ali')
        ->assertOk()
        ->assertSee('alice')
        ->assertDontSee('bob');

    $this->get('/?q=Wonder')
        ->assertOk()
        ->assertSee('alice')
        ->assertDontSee('bob');
});

it('shows public profile page at /users/{username}', function () {
    $user = User::factory()->create(['name' => 'Charlie']);

    Profile::create([
        'user_id' => $user->id,
        'username' => 'charlie',
        'display_name' => 'Charlie C.',
        'bio' => 'Hello world',
    ]);

    $this->get('/users/charlie')
        ->assertOk()
        ->assertSee('Charlie C.')
        ->assertSee('@charlie');
});

