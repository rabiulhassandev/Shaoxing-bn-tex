<?php

use App\Mail\InquiryReceivedMail;
use App\Models\Fabric;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;

it('adds a fabric to the inquiry basket', function () {
    $fabric = Fabric::factory()->create();

    $this->post(route('inquiry.add', $fabric))->assertRedirect();

    expect(session('inquiry_basket'))->toBe([$fabric->id]);
});

it('does not add the same fabric twice', function () {
    $fabric = Fabric::factory()->create();

    $this->post(route('inquiry.add', $fabric));
    $this->post(route('inquiry.add', $fabric));

    expect(session('inquiry_basket'))->toBe([$fabric->id]);
});

it('removes a fabric from the basket', function () {
    $fabric = Fabric::factory()->create();

    $this->withSession(['inquiry_basket' => [$fabric->id]])
        ->delete(route('inquiry.remove', $fabric))
        ->assertRedirect();

    expect(session('inquiry_basket'))->toBe([]);
});

it('shows basket contents on the inquiry page', function () {
    $fabric = Fabric::factory()->create();

    $this->withSession(['inquiry_basket' => [$fabric->id]])
        ->get(route('inquiry.index'))
        ->assertSuccessful()
        ->assertSee($fabric->name)
        ->assertSee('Submit inquiry');
});

it('shows an empty state when the basket is empty', function () {
    $this->get(route('inquiry.index'))
        ->assertSuccessful()
        ->assertSee('Your inquiry basket is empty');
});

it('submits a consolidated inquiry, stores items and queues the notification mail', function () {
    Mail::fake();
    Setting::setMany(['notification_email' => 'sales@bntex.test']);
    [$fabricA, $fabricB] = Fabric::factory()->count(2)->create();

    $this->withSession(['inquiry_basket' => [$fabricA->id, $fabricB->id]])
        ->post(route('inquiry.store'), [
            'name' => 'Jane Buyer',
            'email' => 'jane@example.com',
            'company' => 'Jane Imports GmbH',
            'country' => 'Germany',
            'phone' => '+49 170 000000',
            'message' => 'Please quote CIF Hamburg.',
            'items' => [
                ['fabric_id' => $fabricA->id, 'quantity' => '5,000 m', 'target_price' => '$2.00/m', 'note' => 'Navy shade'],
                ['fabric_id' => $fabricB->id, 'quantity' => '2,000 m'],
            ],
        ])
        ->assertRedirect(route('inquiry.index'))
        ->assertSessionHas('inquirySubmitted', true);

    $this->assertDatabaseCount('inquiries', 1);
    $this->assertDatabaseHas('inquiries', ['email' => 'jane@example.com', 'status' => 'new']);
    $this->assertDatabaseHas('inquiry_items', [
        'fabric_id' => $fabricA->id,
        'fabric_name' => $fabricA->name,
        'quantity' => '5,000 m',
        'target_price' => '$2.00/m',
    ]);
    $this->assertDatabaseCount('inquiry_items', 2);

    expect(session('inquiry_basket'))->toBeNull();

    Mail::assertQueued(InquiryReceivedMail::class, fn (InquiryReceivedMail $mail) => $mail->hasTo('sales@bntex.test'));
});

it('rejects an inquiry submission without items', function () {
    $this->post(route('inquiry.store'), [
        'name' => 'Jane Buyer',
        'email' => 'jane@example.com',
    ])->assertSessionHasErrors('items');

    $this->assertDatabaseCount('inquiries', 0);
});

it('silently discards spam submissions that fill the honeypot', function () {
    Mail::fake();
    $fabric = Fabric::factory()->create();

    $this->post(route('inquiry.store'), [
        'name' => 'Spam Bot',
        'email' => 'spam@example.com',
        'website' => 'http://spam.example',
        'items' => [['fabric_id' => $fabric->id]],
    ])->assertRedirect(route('inquiry.index'));

    $this->assertDatabaseCount('inquiries', 0);
    Mail::assertNothingOutgoing();
});
