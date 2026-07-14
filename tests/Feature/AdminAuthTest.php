<?php

use App\Models\User;

it('redirects guests from the admin panel to the login page', function () {
    $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
    $this->get(route('admin.fabrics.index'))->assertRedirect(route('admin.login'));
});

it('lets an admin log in with valid credentials', function () {
    $user = User::factory()->create();

    $this->post(route('admin.login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticatedAs($user);
});

it('rejects invalid credentials', function () {
    $user = User::factory()->create();

    $this->from(route('admin.login'))->post(route('admin.login.store'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ])->assertRedirect(route('admin.login'))->assertSessionHasErrors('email');

    $this->assertGuest();
});

it('lets an admin view the dashboard and log out', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('admin.dashboard'))->assertSuccessful()->assertSee('Dashboard');
    $this->actingAs($user)->post(route('admin.logout'))->assertRedirect(route('admin.login'));
    $this->assertGuest();
});
