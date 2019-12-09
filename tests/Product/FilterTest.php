<?php

namespace Marktstand\Tests\Product;

use Marktstand\Exceptions\DuplicateSlugException;
use Marktstand\Product\Filter;
use Marktstand\Product\Product;
use Marktstand\Tests\TestCase;

class FilterTest extends TestCase
{
    /** @test */
    public function it_belongs_to_products()
    {
        $filter = factory(Filter::class)->create();
        $product = factory(Product::class)->create();

        $filter->products()->attach([$product->id]);

        $this->assertDatabaseHas('filter_product', [
            'filter_id' => $filter->id,
            'product_id' => $product->id,
        ]);

        $this->assertCount(1, $filter->products);
    }

    /** @test */
    public function it_generates_a_slug()
    {
        $filter = Filter::forceCreate([
            'title' => 'Peanuts',
        ]);

        $this->assertEquals('peanuts', $filter->slug);
    }

    /** @test */
    public function it_validates_the_slug()
    {
        $this->expectException(DuplicateSlugException::class);

        factory(Filter::class)->create([
            'title' => 'Peanuts',
            'slug' => 'peanuts',
        ]);

        $filter = Filter::forceCreate([
            'title' => 'Peanuts',
        ]);
    }

    /** @test */
    public function it_gets_instances_from_slugs()
    {
        factory(Filter::class)->create([
            'title' => 'Peanuts',
            'slug' => 'peanuts',
        ]);

        factory(Filter::class)->create([
            'title' => 'Eggs',
            'slug' => 'eggs',
        ]);

        factory(Filter::class)->create([
            'title' => 'Fish',
            'slug' => 'fish',
        ]);

        factory(Filter::class)->create([
            'title' => 'Cheese',
            'slug' => 'cheese',
        ]);

        $filters = Filter::allFromSlugs(['peanuts', 'eggs', 'fish']);

        $this->assertEquals(['eggs', 'fish', 'peanuts'], $filters->pluck('slug')->toArray());
    }

    /** @test */
    public function it_gets_instances_except_from_slugs()
    {
        factory(Filter::class)->create([
            'title' => 'Peanuts',
            'slug' => 'peanuts',
        ]);

        factory(Filter::class)->create([
            'title' => 'Eggs',
            'slug' => 'eggs',
        ]);

        factory(Filter::class)->create([
            'title' => 'Fish',
            'slug' => 'fish',
        ]);

        factory(Filter::class)->create([
            'title' => 'Cheese',
            'slug' => 'cheese',
        ]);

        $filters = Filter::exceptFromSlugs(['peanuts', 'eggs', 'fish']);

        $this->assertEquals(['cheese'], $filters->pluck('slug')->toArray());
    }
}
