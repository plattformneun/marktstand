<?php

namespace Marktstand\Tests\Product;

use Illuminate\Support\Facades\Event;
use Marktstand\Events\ProductSaved;
use Marktstand\Product\Category;
use Marktstand\Product\Filter;
use Marktstand\Product\Product;
use Marktstand\Product\Quality;
use Marktstand\Tests\TestCase;
use Marktstand\Users\Producer;

class ProductTest extends TestCase
{
    /** @test */
    public function it_fires_the_saved_event()
    {
        Event::fake();

        factory(Product::class)->create();

        Event::assertDispatched(ProductSaved::class);
    }

    /** @test */
    public function it_has_a_producer()
    {
        $producer = factory(Producer::class)->create();
        $product = factory(Product::class)->create(['producer_id' => $producer->id]);

        $this->assertEquals($producer->id, $product->producer->id);
    }

    /** @test */
    public function it_belongs_to_categories()
    {
        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create();

        $product->categories()->attach([$category->id]);

        $this->assertDatabaseHas('category_product', [
            'category_id' => $category->id,
            'product_id' => $product->id,
        ]);

        $this->assertCount(1, $product->categories);
    }

    /** @test */
    public function it_belongs_to_filters()
    {
        $filter = factory(Filter::class)->create();
        $product = factory(Product::class)->create();

        $product->filters()->attach([$filter->id]);

        $this->assertDatabaseHas('filter_product', [
            'filter_id' => $filter->id,
            'product_id' => $product->id,
        ]);

        $this->assertCount(1, $product->filters);
    }

    /** @test */
    public function it_belongs_to_qualities()
    {
        $quality = factory(Quality::class)->create();
        $product = factory(Product::class)->create();

        $product->qualities()->attach([$quality->id]);

        $this->assertDatabaseHas('qualifyables', [
            'quality_id' => $quality->id,
            'qualifyable_id' => $product->id,
            'qualifyable_type' => 'product',
        ]);

        $this->assertCount(1, $product->qualities);

        $this->assertCount(1, $quality->products);
    }
}
