<?php

use App\Models\Fabric;
use App\Models\HeroSlide;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Stat;

it('renders the home page with content', function () {
    HeroSlide::factory()->create(['title' => 'Sourcing Made Simple']);
    Stat::factory()->create(['label' => 'Years of Experience']);
    $fabric = Fabric::factory()->featured()->create();
    Partner::factory()->buyer()->create(['name' => 'ACME APPAREL']);
    Post::factory()->create(['title' => 'Trade Fair Announcement']);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('Sourcing Made Simple')
        ->assertSee('Years of Experience')
        ->assertSee($fabric->name)
        ->assertSee('ACME APPAREL')
        ->assertSee('Trade Fair Announcement');
});

it('renders content pages from the pages table', function (string $slug) {
    Page::factory()->create(['slug' => $slug, 'title' => 'Heading for '.$slug, 'body' => '<p>Body text here.</p>']);

    $this->get('/'.$slug)
        ->assertSuccessful()
        ->assertSee('Heading for '.$slug)
        ->assertSee('Body text here.');
})->with(['about', 'sourcing', 'sustainability']);

it('renders the buyers page with buyer and vendor logos', function () {
    Partner::factory()->buyer()->create(['name' => 'BUYER BRAND']);
    Partner::factory()->vendor()->create(['name' => 'Vendor Mill Co']);

    $this->get(route('buyers'))
        ->assertSuccessful()
        ->assertSee('BUYER BRAND')
        ->assertSee('Vendor Mill Co');
});

it('renders the news index with published posts only', function () {
    Post::factory()->create(['title' => 'Published Story']);
    Post::factory()->draft()->create(['title' => 'Hidden Draft']);

    $this->get(route('news.index'))
        ->assertSuccessful()
        ->assertSee('Published Story')
        ->assertDontSee('Hidden Draft');
});

it('renders a published news post and 404s for drafts', function () {
    $published = Post::factory()->create();
    $draft = Post::factory()->draft()->create();

    $this->get(route('news.show', $published))->assertSuccessful()->assertSee($published->title);
    $this->get(route('news.show', $draft))->assertNotFound();
});

it('renders the contact page', function () {
    $this->get(route('contact'))->assertSuccessful()->assertSee('Get in touch');
});

it('generates an xml sitemap including fabrics and posts', function () {
    $fabric = Fabric::factory()->create();
    $post = Post::factory()->create();

    $this->get(route('sitemap'))
        ->assertSuccessful()
        ->assertHeader('Content-Type', 'application/xml')
        ->assertSee(route('fabrics.show', $fabric), false)
        ->assertSee(route('news.show', $post), false);
});
