<?php

namespace Marktstand\Tests\Product;

use Marktstand\Tests\TestCase;
use Marktstand\Product\Product;

class PriceTest extends TestCase
{
    /** @test */
    public function it_calculates_a_quantity_products_price()
    {
        $product = factory(Product::class)->create([
            'unit' => 'pc',
            'price' => 1000,
            'price_unit' => 'pc',
            'volume' => 500,
            'volume_unit' => 'ml'
        ]);

        $this->assertEquals(1000, $product->price()->amount());
        $this->assertEquals('pc', $product->price()->unit());

        $this->assertEquals(2000, $product->basePrice()->amount());
        $this->assertEquals('l', $product->basePrice()->unit());
    }

    /** @test */
    public function it_calculates_a_variable_quantity_products_price()
    {
        $product = factory(Product::class)->create([
            'unit' => 'pc',
            'price' => 2000,
            'price_unit' => 'kg',
            'volume' => 500,
            'volume_unit' => 'g'
        ]);

        $this->assertEquals(1000, $product->price()->amount());
        $this->assertEquals('pc', $product->price()->unit());

        $this->assertEquals(2000, $product->basePrice()->amount());
        $this->assertEquals('kg', $product->basePrice()->unit());
    }

    /** @test */
    public function it_calculates_a_weight_products_price()
    {
        $product = factory(Product::class)->create([
            'unit' => 'kg',
            'price' => 1000,
            'price_unit' => 'kg',
            'volume' => 1,
            'volume_unit' => 'kg'
        ]);

        $this->assertEquals(1000, $product->price()->amount());
        $this->assertEquals('kg', $product->price()->unit());

        $this->assertEquals(1000, $product->basePrice()->amount());
        $this->assertEquals('kg', $product->basePrice()->unit());
    }
}
