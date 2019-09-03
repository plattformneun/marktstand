<?php

namespace Marktstand\Tests\Checkout;

use Marktstand\Tests\TestCase;
use Marktstand\Users\Supplier;
use Marktstand\Product\Product;
use Marktstand\Checkout\Cart\Cart;
use Marktstand\Checkout\Cart\Item;
use Illuminate\Support\Facades\Config;

class DeliveryTest extends TestCase
{
    /** @test */
    public function it_calculates_the_subtotal()
    {
        $cart = factory(Cart::class)->create();

        $item = factory(Item::class)->create([
            'cart_id' => $cart->id,
        ]);

        $delivery = $cart->deliveries->first();

        $this->assertTrue($item->total === $delivery->subtotal());
    }

    /** @test */
    public function it_calculates_the_shipping_charge()
    {
        // Remove commission.
        Config::set('marktstand.commission', 0);

        $product = factory(Product::class)->create([
            'unit' => 'kg',
            'volume' => 1,
            'volume_unit' => 'kg',
            'price' => 1000,
            'price_unit' => 'kg',
        ]);

        $supplier = factory(Supplier::class)->create([
            'charge' => 1000,
            'free_shipping_at' => 2000,
        ]);

        $cart = factory(Cart::class)->create();

        $item = factory(Item::class)->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $delivery = $cart->deliveries->first();

        $this->assertEquals(1000, $delivery->shipping());
    }

    /** @test */
    public function it_calculates_free_shipping()
    {
        // Remove commission.
        Config::set('marktstand.commission', 0);

        $product = factory(Product::class)->create([
            'unit' => 'kg',
            'volume' => 1,
            'volume_unit' => 'kg',
            'price' => 2000,
            'price_unit' => 'kg',
        ]);

        $supplier = factory(Supplier::class)->create([
            'charge' => 1000,
            'free_shipping_at' => 2000,
        ]);

        $cart = factory(Cart::class)->create();

        $item = factory(Item::class)->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $delivery = $cart->deliveries->first();

        $this->assertEquals(0, $delivery->shipping());
    }

    /** @test */
    public function it_calculates_the_vat()
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

        $cart = factory(Cart::class)->create();

        $item = factory(Item::class)->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);

        $delivery = $cart->deliveries->first();

        $this->assertCount(1, $delivery->vat());
        $this->assertEquals(200, $delivery->vat()[10]);
    }

    /** @test */
    public function it_calculates_the_delivery_days()
    {
        $product = factory(Product::class)->create([
            'lead_time' => 2,
        ]);

        $supplier = factory(Supplier::class)->create([
            'delivery_times' => [1],
        ]);

        $cart = factory(Cart::class)->create();

        $item = factory(Item::class)->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'supplier_id' => $supplier->id,
        ]);

        $delivery = $cart->deliveries->first();

        $this->assertCount(2, $delivery->days(14));
        $this->assertEquals(1, $delivery->days(14)->first()->dayOfWeek);
    }

    /** @test */
    public function it_checks_the_minimum_order_value()
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

        $item = factory(Item::class)->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'supplier_id' => $supplier->id,
        ]);

        $delivery = $cart->deliveries->first();

        $this->assertFalse($delivery->hasMinimumOrderValue());

        $product->price = $supplier->min_order_value;
        $product->save();
        $delivery = $cart->fresh()->deliveries->first();

        $this->assertTrue($delivery->hasMinimumOrderValue());
    }
}
