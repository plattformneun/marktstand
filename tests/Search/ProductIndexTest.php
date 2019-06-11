<?php

namespace Marktstand\Tests\Search;

use Marktstand\Product\Product;
use Marktstand\Search\ProductIndex;
use Marktstand\Tests\TestCase;

class ProductIndexTest extends TestCase
{
    /** @test */
    public function it_fetches_the_index_key()
    {
        $product = factory(Product::class)->create();

        $index = new ProductIndex($product);

        $this->assertEquals('product:'.$product->id, $index->getKey());
    }

    /** @test */
    public function it_fetches_the_indexable_attributes()
    {
        $product = factory(Product::class)->create();

        $index = new ProductIndex($product);

        $this->assertEquals([
            'title' => 'Rinderfilet',
            'producer' => null,
            'price' => 1380
        ], $index->toArray());
    }

    /** @test */
    public function it_converts_to_json()
    {
        $product = factory(Product::class)->create();

        $index = new ProductIndex($product);

        $this->assertEquals(json_encode($index->toArray()), (string) $index);
    }
}
