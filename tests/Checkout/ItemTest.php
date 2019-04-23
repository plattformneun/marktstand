<?php

namespace Marktstand\Tests\Checkout;

use Marktstand\Checkout\Item;
use Marktstand\Product\Price;
use Marktstand\Tests\TestCase;
use Marktstand\Product\Product;

class ItemTest extends TestCase
{
    /** @test */
    public function it_belongs_to_a_product()
    {
        $item = factory(Item::class)->create();

        $this->assertTrue($item->product instanceof Product);
    }
}
