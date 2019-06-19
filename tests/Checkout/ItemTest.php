<?php

namespace Marktstand\Tests\Checkout;

use Marktstand\Checkout\Item;
use Marktstand\Tests\TestCase;
use Marktstand\Product\Product;
use Illuminate\Support\Facades\Config;

class ItemTest extends TestCase
{
    /** @test */
    public function it_belongs_to_a_product()
    {
        $item = factory(Item::class)->create();

        $this->assertTrue($item->product instanceof Product);
    }

    /** @test */
    public function it_calculates_the_price_for_portion_product_items()
    {
        $item = factory(Item::class)->create([
            'quantity' => 5,
            'product_id' => factory(Product::class)->create([
                'title' => 'Rinderfilet',
                'unit' => 'portion',
                'volume' => 1000,
                'volume_unit' => 'g',
                'price' => 1000,
                'price_unit' => 'kg',
                'vat' => 7,
                'producer_id' => 1,
                ])->id,
            'checkout_id' => 1,
            'checkout_type' => 'cart',
        ]);

        $this->assertEquals(5000, $item->price);
    }

    /** @test */
    public function it_calculates_the_price_for_value_product_items()
    {
        $item = factory(Item::class)->create([
            'quantity' => 5,
            'product_id' => factory(Product::class)->create([
                'title' => 'Apfel',
                'unit' => 'kg',
                'volume' => 1,
                'volume_unit' => 'kg',
                'price' => 500,
                'price_unit' => 'kg',
                'vat' => 7,
                'producer_id' => 1,
                ])->id,
            'checkout_id' => 1,
            'checkout_type' => 'cart',
        ]);

        $this->assertEquals(2500, $item->price);
    }

    /** @test */
    public function it_calculates_the_total_checkout_price()
    {
        Config::set('marktstand.commission', 25);

        $item = factory(Item::class)->create([
            'quantity' => 5,
            'product_id' => factory(Product::class)->create([
                'title' => 'Rinderfilet',
                'unit' => 'portion',
                'volume' => 1000,
                'volume_unit' => 'g',
                'price' => 1000,
                'price_unit' => 'kg',
                'vat' => 7,
                'producer_id' => 1,
                ])->id,
            'checkout_id' => 1,
            'checkout_type' => 'cart',
        ]);

        $this->assertEquals(6250, $item->getTotalPrice());
        $this->assertEquals(6250, $item->total);
    }
}
