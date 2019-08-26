<?php

namespace Marktstand\Tests\Checkout;

use Marktstand\Checkout\Cart;
use Marktstand\Tests\TestCase;
use Marktstand\Users\Customer;
use Marktstand\Users\Producer;
use Marktstand\Users\Supplier;
use Marktstand\Product\Product;
use Marktstand\Checkout\CartItem;
use Marktstand\Checkout\Delivery;
use Illuminate\Support\Facades\Config;

class CartTest extends TestCase
{
    /** @test */
    public function it_belongs_to_a_customer()
    {
        $cart = factory(Cart::class)->create();

        $this->assertTrue($cart->customer instanceof Customer);
    }

    /** @test */
    public function it_may_has_many_cart_items()
    {
        $cart = factory(Cart::class)->create();

        $item = factory(CartItem::class)->create([
            'cart_id' => $cart->id,
        ]);

        $this->assertCount(1, $cart->items);
    }

    /** @test */
    public function it_may_has_many_deliveries()
    {
        $cart = factory(Cart::class)->create();

        $item = factory(CartItem::class)->create([
            'cart_id' => $cart->id,
        ]);

        $this->assertCount(1, $cart->deliveries);
        $this->assertTrue($cart->deliveries->first() instanceof Delivery);
    }

    /** @test */
    public function it_filters_unprocessable_deliveries()
    {
        // Remove commission.
        Config::set('marktstand.commission', 0);
        $product = factory(Product::class)->create([
            'unit' => 'kg',
            'volume' => 1,
            'volume_unit' => 'kg',
            'price' => 1000,
            'price_unit' => 'kg',
            'vat' => 10,
        ]);

        $supplier = factory(Supplier::class)->create([
            'min_order_value' => 2000,
        ]);

        $cart = factory(Cart::class)->create();

        $item = factory(CartItem::class)->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'supplier_id' => $supplier->id,
        ]);

        $this->assertCount(0, $cart->processable());

        $product->price = $supplier->min_order_value;
        $product->save();

        $this->assertCount(1, $cart->fresh()->processable());
    }

    /** @test */
    public function it_calculates_the_subtotal()
    {
        // Remove commission.
        Config::set('marktstand.commission', 0);
        $product = factory(Product::class)->create([
            'unit' => 'kg',
            'volume' => 1,
            'volume_unit' => 'kg',
            'price' => 2000,
            'price_unit' => 'kg',
            'vat' => 10,
        ]);

        $supplier = factory(Supplier::class)->create([
            'min_order_value' => 1000,
        ]);

        $cart = factory(Cart::class)->create();

        $item = factory(CartItem::class)->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'supplier_id' => $supplier->id,
        ]);

        $this->assertEquals(2000, $cart->subtotal());
    }

    /** @test */
    public function it_calculates_the_vat()
    {
        $cart = factory(Cart::class)->create();

        $producerA = factory(Producer::class)->create(['email' => 'a@example.com']);
        $producerB = factory(Producer::class)->create(['email' => 'b@example.com']);

        $supplierA = factory(Supplier::class)->create(['min_order_value' => 0, 'user_id' => $producerA->id, 'user_type' => $producerA->type]);
        $supplierB = factory(Supplier::class)->create(['min_order_value' => 0, 'user_id' => $producerB->id, 'user_type' => $producerB->type]);

        $productA = factory(Product::class)->create(['producer_id' => $producerA->id]);
        $productB = factory(Product::class)->create(['producer_id' => $producerB->id]);

        factory(CartItem::class)->create([
            'cart_id' => $cart->id,
            'product_id' => $productA->id,
            'producer_id' => $producerA->id,
            'supplier_id' => $supplierA->id,
            'quantity' => 1,
        ]);

        factory(CartItem::class)->create([
            'cart_id' => $cart->id,
            'product_id' => $productB->id,
            'producer_id' => $producerB->id,
            'supplier_id' => $supplierB->id,
            'quantity' => 1,
        ]);

        $this->assertCount(1, $cart->vat());
    }

    /** @test */
    public function it_calculates_the_shipping()
    {
        $cart = factory(Cart::class)->create();

        $producerA = factory(Producer::class)->create(['email' => 'a@example.com']);
        $producerB = factory(Producer::class)->create(['email' => 'b@example.com']);

        $supplierA = factory(Supplier::class)->create(['min_order_value' => 0, 'charge' => 1000, 'user_id' => $producerA->id, 'user_type' => $producerA->type]);
        $supplierB = factory(Supplier::class)->create(['min_order_value' => 0, 'charge' => 1000, 'user_id' => $producerB->id, 'user_type' => $producerB->type]);

        $productA = factory(Product::class)->create(['producer_id' => $producerA->id]);
        $productB = factory(Product::class)->create(['producer_id' => $producerB->id]);

        factory(CartItem::class)->create([
            'cart_id' => $cart->id,
            'product_id' => $productA->id,
            'producer_id' => $producerA->id,
            'supplier_id' => $supplierA->id,
            'quantity' => 1,
        ]);

        factory(CartItem::class)->create([
            'cart_id' => $cart->id,
            'product_id' => $productB->id,
            'producer_id' => $producerB->id,
            'supplier_id' => $supplierB->id,
            'quantity' => 1,
        ]);

        $this->assertEquals(2000, $cart->shipping());
    }

    /** @test */
    public function it_calculates_the_total_amount()
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
            'quantity' => 1,
        ]);

        factory(CartItem::class)->create([
            'cart_id' => $cart->id,
            'product_id' => $productB->id,
            'producer_id' => $producerB->id,
            'supplier_id' => $supplierB->id,
            'quantity' => 1,
        ]);

        $this->assertEquals(6400, $cart->total());
    }
}
