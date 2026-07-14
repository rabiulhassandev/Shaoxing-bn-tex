<?php

use App\Enums\InquiryStatus;
use App\Models\ContactMessage;
use App\Models\Fabric;
use App\Models\FabricCategory;
use App\Models\Inquiry;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('creates a fabric category', function () {
    $this->post(route('admin.categories.store'), [
        'name' => '100% Cotton',
        'slug' => '',
        'description' => 'Pure cotton qualities.',
        'sort_order' => 1,
        'is_active' => '1',
    ])->assertRedirect(route('admin.categories.index'));

    $this->assertDatabaseHas('fabric_categories', ['name' => '100% Cotton', 'slug' => '100-cotton']);
});

it('creates a fabric with a main image and gallery', function () {
    Storage::fake('public');
    $category = FabricCategory::factory()->create();

    $this->post(route('admin.fabrics.store'), [
        'category_id' => $category->id,
        'name' => 'Cotton Poplin 40s',
        'slug' => '',
        'image' => UploadedFile::fake()->create('main.jpg', 100, 'image/jpeg'),
        'gallery' => [UploadedFile::fake()->create('detail.jpg', 100, 'image/jpeg')],
        'construction' => '40x40 133x72',
        'composition' => '100% Cotton',
        'width' => '57/58"',
        'weight' => '110 GSM',
        'is_featured' => '0',
        'is_active' => '1',
    ])->assertRedirect(route('admin.fabrics.index'));

    $fabric = Fabric::query()->where('slug', 'cotton-poplin-40s')->firstOrFail();

    expect($fabric->image)->not->toBeNull()
        ->and($fabric->images)->toHaveCount(1);

    Storage::disk('public')->assertExists($fabric->image);
    Storage::disk('public')->assertExists($fabric->images->first()->path);
});

it('updates a fabric and keeps the existing image when none is uploaded', function () {
    $fabric = Fabric::factory()->create(['image' => 'fabrics/existing.jpg']);

    $this->put(route('admin.fabrics.update', $fabric), [
        'category_id' => $fabric->category_id,
        'name' => 'Renamed Fabric',
        'slug' => $fabric->slug,
        'is_featured' => '1',
        'is_active' => '1',
    ])->assertRedirect(route('admin.fabrics.index'));

    $fabric->refresh();

    expect($fabric->name)->toBe('Renamed Fabric')
        ->and($fabric->is_featured)->toBeTrue()
        ->and($fabric->image)->toBe('fabrics/existing.jpg');
});

it('deletes a fabric', function () {
    $fabric = Fabric::factory()->create();

    $this->delete(route('admin.fabrics.destroy', $fabric))->assertRedirect(route('admin.fabrics.index'));

    $this->assertDatabaseMissing('fabrics', ['id' => $fabric->id]);
});

it('updates the status of an inquiry', function () {
    $inquiry = Inquiry::factory()->create();

    $this->put(route('admin.inquiries.update', $inquiry), ['status' => 'in_progress'])->assertRedirect();

    expect($inquiry->refresh()->status)->toBe(InquiryStatus::InProgress);
});

it('marks a contact message as read when viewed', function () {
    $message = ContactMessage::factory()->create();

    $this->get(route('admin.messages.show', $message))->assertSuccessful();

    expect($message->refresh()->is_read)->toBeTrue();
});

it('saves site settings', function () {
    $this->put(route('admin.settings.update'), [
        'company_name' => 'SHAOXING BN TEX',
        'contact_email' => 'info@bntex.test',
        'notification_email' => 'sales@bntex.test',
    ])->assertRedirect()->assertSessionHas('status');

    expect(Setting::get('company_name'))->toBe('SHAOXING BN TEX')
        ->and(Setting::get('notification_email'))->toBe('sales@bntex.test');
});
