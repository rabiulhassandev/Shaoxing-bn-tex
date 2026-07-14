<?php

use App\Models\Fabric;
use App\Models\FabricCategory;

it('lists only active fabrics in the catalogue', function () {
    $active = Fabric::factory()->create();
    $inactive = Fabric::factory()->inactive()->create();

    $this->get(route('fabrics.index'))
        ->assertSuccessful()
        ->assertSee($active->name)
        ->assertDontSee($inactive->name);
});

it('filters the catalogue by category slug', function () {
    $denim = FabricCategory::factory()->create(['name' => 'Denim', 'slug' => 'denim']);
    $cotton = FabricCategory::factory()->create(['name' => 'Cotton', 'slug' => 'cotton']);
    $denimFabric = Fabric::factory()->for($denim, 'category')->create();
    $cottonFabric = Fabric::factory()->for($cotton, 'category')->create();

    $this->get(route('fabrics.index', ['category' => 'denim']))
        ->assertSuccessful()
        ->assertSee($denimFabric->name)
        ->assertDontSee($cottonFabric->name);
});

it('searches fabrics by name', function () {
    $match = Fabric::factory()->create(['name' => 'Stretch Denim Special']);
    $other = Fabric::factory()->create(['name' => 'Linen Classic']);

    $this->get(route('fabrics.index', ['search' => 'Stretch Denim']))
        ->assertSuccessful()
        ->assertSee($match->name)
        ->assertDontSee($other->name);
});

it('shows the fabric detail page with full specifications', function () {
    $fabric = Fabric::factory()->create([
        'construction' => '40x40 133x72',
        'moq' => '1,500 m per colour',
        'lead_time' => '30-35 days',
    ]);

    $this->get(route('fabrics.show', $fabric))
        ->assertSuccessful()
        ->assertSee($fabric->name)
        ->assertSee('40x40 133x72')
        ->assertSee('1,500 m per colour')
        ->assertSee('30-35 days')
        ->assertSee('Add to inquiry');
});

it('returns 404 for an inactive fabric detail page', function () {
    $fabric = Fabric::factory()->inactive()->create();

    $this->get(route('fabrics.show', $fabric))->assertNotFound();
});
