<?php

namespace Marktstand\Tests\Checkout;

use Marktstand\Checkout\Cart;
use Marktstand\Checkout\Item;
use Marktstand\Checkout\Order;
use Marktstand\Product\Product;
use Marktstand\Tests\TestCase;
use Marktstand\Users\Producer;

class OrderTest extends TestCase
{
    /** @test */
    public function it_can_created_from_cart()
    {
        $producerA = factory(Producer::class)->create([
            'id' => 10,
            'email' => 'johndoe@example.com'
        ]);

        $producerB = factory(Producer::class)->create([
            'id' => 50,
            'email' => 'janedoe@example.com'
        ]);

        $productA = factory(Product::class)->create([
            'producer_id' => $producerA->id
        ]);

        $productB = factory(Product::class)->create([
            'producer_id' => $producerB->id
        ]);

        $cart = factory(Cart::class)->create();

        $itemA = factory(Item::class)->create([
            'product_id' => $productA->id,
            'checkout_id' => $cart->id,
            'checkout_type' => 'cart',
        ]);

        $itemB = factory(Item::class)->create([
            'product_id' => $productB->id,
            'checkout_id' => $cart->id,
            'checkout_type' => 'cart',
        ]);

        Order::createFromCart($cart);

        $this->assertCount(2, $cart->customer->orders);
        $this->assertEquals('order', $itemA->fresh()->checkout_type);
        $this->assertEquals('order', $itemB->fresh()->checkout_type);
    }
}
