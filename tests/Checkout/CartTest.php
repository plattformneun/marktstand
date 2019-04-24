<?php

namespace Marktstand\Tests\Checkout;

use Marktstand\Checkout\Cart;
use Marktstand\Checkout\Item;
use Marktstand\Tests\TestCase;
use Marktstand\Product\Product;

class CartTest extends TestCase
{
    /** @test */
    public function it_has_many_items()
    {
        $cart = factory(Cart::class)->create();

        factory(Item::class, 10)->create([
            'product_id' => 1,
            'checkout_id' => $cart->id,
            'checkout_type' => 'cart',
        ]);

        $this->assertCount(10, $cart->items);
    }
}
