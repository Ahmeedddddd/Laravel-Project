<?php

use App\Models\Profile;
use App\Models\User;

it('escapes bio on public profile page (xss protection)', function () {
    $user = User::factory()->create(['name' => 'Eve']);

    Profile::create([
        'user_id' => $user->id,
        'username' => 'eve',
        'display_name' => 'Eve',
        'bio' => '<script>alert("xss")</script>',
    ]);

    $this->get('/users/eve')
        ->assertOk()
        ->assertSee('&lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;', false)
        ->assertDontSee('<script>alert("xss")</script>', false);
});

