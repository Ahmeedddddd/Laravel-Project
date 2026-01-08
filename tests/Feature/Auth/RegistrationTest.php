<?php

use App\Models\Profile;
use App\Models\User;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));

    /** @var User $user */
    $user = User::where('email', 'test@example.com')->firstOrFail();

    expect(Profile::where('user_id', $user->id)->count())->toBe(1);

    $profile = $user->profile()->first();
    expect($profile)->not->toBeNull();
    expect($profile->username)->not->toBeEmpty();

    // Public members index should include the new user (it filters by existing profile.username).
    $this->get('/members?q=testuser')
        ->assertOk()
        ->assertSee($profile->username);
});
