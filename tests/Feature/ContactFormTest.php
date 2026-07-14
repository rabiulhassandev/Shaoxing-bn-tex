<?php

use App\Mail\ContactMessageMail;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;

it('stores a contact message and queues the notification mail', function () {
    Mail::fake();
    Setting::setMany(['notification_email' => 'sales@bntex.test']);

    $this->post(route('contact.store'), [
        'name' => 'John Buyer',
        'email' => 'john@example.com',
        'subject' => 'Shipping terms',
        'message' => 'Do you ship FOB Ningbo?',
    ])->assertRedirect(route('contact'))->assertSessionHas('status');

    $this->assertDatabaseHas('contact_messages', [
        'email' => 'john@example.com',
        'subject' => 'Shipping terms',
        'is_read' => false,
    ]);

    Mail::assertQueued(ContactMessageMail::class, fn (ContactMessageMail $mail) => $mail->hasTo('sales@bntex.test'));
});

it('validates required contact form fields', function () {
    $this->post(route('contact.store'), [])
        ->assertSessionHasErrors(['name', 'email', 'message']);

    $this->assertDatabaseCount('contact_messages', 0);
});

it('silently discards contact submissions that fill the honeypot', function () {
    Mail::fake();

    $this->post(route('contact.store'), [
        'name' => 'Spam Bot',
        'email' => 'spam@example.com',
        'message' => 'Buy things',
        'website' => 'http://spam.example',
    ])->assertRedirect(route('contact'));

    $this->assertDatabaseCount('contact_messages', 0);
    Mail::assertNothingOutgoing();
});
