<?php

namespace Marktstand\Tests\Resources;

use Illuminate\Support\Facades\Config;
use Marktstand\Checkout\Cart;
use Marktstand\Checkout\CartItem;
use Marktstand\Checkout\Delivery;
use Marktstand\Product\Product;
use Marktstand\Tests\TestCase;
use Marktstand\Users\Producer;
use Marktstand\Users\Supplier;
use Marktstand\Http\Resources\Cart as CartResource;
use Marktstand\Http\Resources\Delivery as DeliveryResource;

class CartTest extends TestCase
{
    /** @test */
    public function it_renders_a_json_response()
    {
        // Remove commission.
        Config::set('marktstand.commission', 0);
        $cart = factory(Cart::class)->create();

        $producerA = factory(Producer::class)->create(['email' => 'a@example.com']);
        $producerB = factory(Producer::class)->create(['email' => 'b@example.com']);

        $supplierA = factory(Supplier::class)->create(['min_order_value' => 0, 'charge' => 1000, 'user_id' => $producerA->id, 'user_type' => $producerA->type]);
        $supplierB = factory(Supplier::class)->create(['min_order_value' => 0, 'charge' => 1000, 'user_id' => $producerB->id, 'user_type' => $producerB->type]);

        $productA = factory(Product::class)->create(['producer_id' => $producerA->id, 'price' => 2000, 'vat' => '10']);
        $productB = factory(Product::class)->create(['producer_id' => $producerB->id, 'price' => 2000, 'vat' => '10']);

        factory(CartItem::class)->create([
            'cart_id' => $cart->id,
            'product_id' => $productA->id,
            'producer_id' => $producerA->id,
            'supplier_id' => $supplierA->id,
            'quantity' => 1
        ]);

        factory(CartItem::class)->create([
            'cart_id' => $cart->id,
            'product_id' => $productB->id,
            'producer_id' => $producerB->id,
            'supplier_id' => $supplierB->id,
            'quantity' => 1
        ]);

        $resource = new CartResource($cart);

        $this->assertEquals(json_encode($resource), json_encode([
            'shipping' => 2000,
            'subtotal' => 4000,
            'total' => 6400,
            'vat' => [10 => 400],
            'deliveries' => $cart->deliveries->map(function($delivery) {
                return new DeliveryResource($delivery);
            })
        ]));
    }
}
