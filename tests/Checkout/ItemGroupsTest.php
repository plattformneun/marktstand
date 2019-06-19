<?php

namespace Marktstand\Tests\Checkout;

use Marktstand\Checkout\Cart;
use Marktstand\Checkout\Item;
use Marktstand\Tests\TestCase;
use Marktstand\Users\Producer;
use Marktstand\Product\Product;
use Illuminate\Support\Facades\Config;

class ItemGroupsTest extends TestCase
{
    /** @test */
    public function it_groups_the_items_by_producer()
    {
        $checkout = factory(Cart::class)->create();

        factory(Item::class, 10)->create([
            'quantity' => 5,
            'product_id' => factory(Product::class)->create([
                'producer_id' => factory(Producer::class)->create([
                    'email' => 'jane@example.com',
                ])->id,
            ]),
            'checkout_id' => $checkout->id,
            'checkout_type' => $checkout->type,
        ]);

        factory(Item::class, 5)->create([
            'quantity' => 5,
            'product_id' => factory(Product::class)->create([
                'producer_id' => factory(Producer::class)->create([
                    'email' => 'john@example.com',
                ])->id,
            ]),
            'checkout_id' => $checkout->id,
            'checkout_type' => $checkout->type,
        ]);

        $this->assertCount(15, $checkout->items);
        $this->assertCount(2, $checkout->contents());
    }

    /** @test */
    public function it_calculates_the_price_per_group()
    {
        Config::set('marktstand.commission', 0);

        $checkout = factory(Cart::class)->create();
        $producer = factory(Producer::class)->create();

        $a = factory(Item::class)->create([
            'quantity' => 5,
            'product_id' => factory(Product::class)->create([
                'unit' => 'portion',
                'volume' => 1000,
                'volume_unit' => 'g',
                'price' => 1000,
                'price_unit' => 'kg',
                'vat' => 7,
                'producer_id' => $producer->id,
            ]),
            'checkout_id' => $checkout->id,
            'checkout_type' => $checkout->type,
        ]);

        $b = factory(Item::class)->create([
            'quantity' => 2,
            'product_id' => factory(Product::class)->create([
                'unit' => 'portion',
                'volume' => 500,
                'volume_unit' => 'ml',
                'price' => 100,
                'price_unit' => 'portion',
                'producer_id' => $producer->id,
            ]),
            'checkout_id' => $checkout->id,
            'checkout_type' => $checkout->type,
        ]);

        $this->assertEquals(
            $a->total + $b->total, $checkout->contents()->first()['total']
        );
    }
}
