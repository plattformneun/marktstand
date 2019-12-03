<?php

namespace Marktstand\Tests\Product;

use Marktstand\Exceptions\DuplicateSlugException;
use Marktstand\Product\Product;
use Marktstand\Product\Quality;
use Marktstand\Tests\TestCase;

class QualityTest extends TestCase
{
    /** @test */
    public function it_belongs_to_products()
    {
        $quality = factory(Quality::class)->create();
        $product = factory(Product::class)->create();

        $quality->products()->attach([$product->id]);

        $this->assertDatabaseHas('qualifyables', [
            'quality_id' => $quality->id,
            'qualifyable_id' => $product->id,
        ]);

        $this->assertCount(1, $quality->products);
    }

    /** @test */
    public function it_generates_a_slug()
    {
        $quality = Quality::forceCreate([
            'title' => 'Demeter',
        ]);

        $this->assertEquals('demeter', $quality->slug);
    }

    /** @test */
    public function it_validates_the_slug()
    {
        $this->expectException(DuplicateSlugException::class);

        factory(Quality::class)->create([
            'title' => 'Demeter',
            'slug' => 'demeter',
        ]);

        $quality = Quality::forceCreate([
            'title' => 'Demeter',
        ]);
    }

    /** @test */
    public function it_gets_instances_from_slugs()
    {
        factory(Quality::class)->create([
            'title' => 'Demeter',
            'slug' => 'demeter',
        ]);

        factory(Quality::class)->create([
            'title' => 'Organic',
            'slug' => 'organic',
        ]);

        $qualities = Quality::allFromSlugs(['demeter']);

        $this->assertEquals(['demeter'], $qualities->pluck('slug')->toArray());
    }
}
