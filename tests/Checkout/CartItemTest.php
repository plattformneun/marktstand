<?php

namespace Marktstand\Tests\Checkout;

use Marktstand\Tests\TestCase;
use Marktstand\Users\Producer;
use Marktstand\Users\Supplier;
use Marktstand\Product\Product;
use Marktstand\Checkout\Cart\Item;

class CartItemTest extends TestCase
{
    /** @test */
    public function it_belongs_to_a_supplier()
    {
        $supplier = factory(Supplier::class)->create();

        $item = factory(Item::class)->create([
            'supplier_id' => $supplier->id,
        ]);

        $this->assertEquals($supplier->fresh(), $item->supplier);
    }

    /** @test */
    public function it_belongs_to_a_producer()
    {
        $producer = factory(Producer::class)->create();

        $item = factory(Item::class)->create([
            'producer_id' => $producer->id,
        ]);

        $this->assertEquals($producer->fresh(), $item->producer);
    }

    /** @test */
    public function it_belongs_to_a_product()
    {
        $product = factory(Product::class)->create();

        $item = factory(Item::class)->create([
            'product_id' => $product->id,
        ]);

        $this->assertEquals($product->fresh(), $item->product);
    }
}
