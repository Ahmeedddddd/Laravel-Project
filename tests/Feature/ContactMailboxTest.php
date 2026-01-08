<?php

use App\Models\ContactMessage;
use App\Models\User;

it('stores a contact message and links it to the authenticated user', function () {
    $user = User::factory()->create([
        'name' => 'Ahmed',
        'email' => 'ahmed@example.com',
        'is_admin' => false,
    ]);

    $this->actingAs($user)
        ->post('/contact', [
            'name' => 'Ahmed',
            'email' => 'ahmed@example.com',
            'subject' => 'Vraag',
            'message' => 'Hallo',
        ])
        ->assertRedirect('/contact');

    $msg = ContactMessage::query()->latest('id')->first();
    expect($msg)->not->toBeNull();
    expect($msg->user_id)->toBe($user->id);
    expect($msg->subject)->toBe('Vraag');
});

it('allows admin to view and reply to contact messages and user sees the reply in their mailbox', function () {
    $user = User::factory()->create(['is_admin' => false]);
    $admin = User::factory()->create(['is_admin' => true]);

    $msg = ContactMessage::create([
        'user_id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'subject' => 'Test',
        'message' => 'Hello',
    ]);

    // Admin can see it
    $this->actingAs($admin)
        ->get('/admin/contact')
        ->assertOk()
        ->assertSee('Test');

    // Admin replies
    $this->actingAs($admin)
        ->post("/admin/contact/{$msg->id}/reply", [
            'admin_reply' => 'Antwoord',
        ])
        ->assertRedirect("/admin/contact/{$msg->id}");

    $msg->refresh();
    expect($msg->admin_reply)->toBe('Antwoord');
    expect($msg->replied_at)->not->toBeNull();

    // User mailbox
    $this->actingAs($user)
        ->get('/account/messages')
        ->assertOk()
        ->assertSee('Test');

    $this->actingAs($user)
        ->get("/account/messages/{$msg->id}")
        ->assertOk()
        ->assertSee('Antwoord');
});

it('forbids non-admin users from accessing the admin contact inbox', function () {
    $user = User::factory()->create(['is_admin' => false]);

    $this->actingAs($user)
        ->get('/admin/contact')
        ->assertForbidden();
});

