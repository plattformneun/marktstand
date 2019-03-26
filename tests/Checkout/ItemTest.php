<?php

namespace Marktstand\Tests\Checkout;

use Marktstand\Checkout\Item;
use Marktstand\Product\Price;
use Marktstand\Product\Product;
use Marktstand\Tests\TestCase;

class ItemTest extends TestCase
{
    /** @test */
    public function it_belongs_to_a_product()
    {
        $item = factory(Item::class)->create();

        $this->assertTrue($item->product instanceof Product);
    }

    /** @test */
    public function it_gets_the_price()
    {
        $item = factory(Item::class)->create();

        $this->assertTrue($item->price() instanceof Price);
    }
}
