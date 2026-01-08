<?php

use App\Models\User;

it('forbids non-admins from deleting users', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $user = User::factory()->create(['is_admin' => false]);

    $this->actingAs($user)
        ->delete(route('admin.users.destroy', $admin))
        ->assertForbidden();
});

it('allows admin to delete a normal user', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $user = User::factory()->create(['is_admin' => false]);

    $this->actingAs($admin)
        ->delete(route('admin.users.destroy', $user))
        ->assertRedirect(route('admin.users.index'));

    expect(User::whereKey($user->id)->exists())->toBeFalse();
});

it('prevents admin from deleting themselves', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin)
        ->delete(route('admin.users.destroy', $admin))
        ->assertRedirect(route('admin.users.index'));

    expect(User::whereKey($admin->id)->exists())->toBeTrue();
});

it('prevents admin from deleting another admin', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $otherAdmin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin)
        ->delete(route('admin.users.destroy', $otherAdmin))
        ->assertForbidden();

    expect(User::whereKey($otherAdmin->id)->exists())->toBeTrue();
});

