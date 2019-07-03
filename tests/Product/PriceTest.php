<?php

namespace Marktstand\Tests\Product;

use Marktstand\Tests\TestCase;
use Marktstand\Product\Product;

class PriceTest extends TestCase
{
    /** @test */
    public function it_calculates_the_portion_price()
    {
        $product = factory(Product::class)->create([
            'unit' => 'portion',
            'volume' => 750,
            'volume_unit' => 'ml',
            'price' => 150,
            'price_unit' => 'portion',
        ]);

        $this->assertEquals(150, $product->price()->value());
    }

    /** @test */
    public function it_calculates_the_value_price()
    {
        $product = factory(Product::class)->create([
            'unit' => 'kg',
            'volume' => 1,
            'volume_unit' => 'kg',
            'price' => 150,
            'price_unit' => 'kg',
        ]);

        $this->assertEquals(150, $product->price()->value());
    }

    /** @test */
    public function it_calculates_the_portion_price_from_value()
    {
        $product = factory(Product::class)->create([
            'unit' => 'portion',
            'volume' => 500,
            'volume_unit' => 'g',
            'price' => 300,
            'price_unit' => 'kg',
        ]);

        $this->assertEquals(150, $product->price()->value());
    }

    /** @test */
    public function it_calculates_the_basic_price_for_equal_units()
    {
        $product = factory(Product::class)->create([
            'unit' => 'portion',
            'volume' => 750,
            'volume_unit' => 'ml',
            'price' => 150,
            'price_unit' => 'portion',
        ]);

        $this->assertEquals(200, $product->price()->base());
    }

    /** @test */
    public function it_calculates_the_base_price_from_value()
    {
        $product = factory(Product::class)->create([
            'unit' => 'portion',
            'volume' => 500,
            'volume_unit' => 'g',
            'price' => 300,
            'price_unit' => 'kg',
        ]);

        $this->assertEquals(300, $product->price()->base());
    }

    /** @test */
    public function it_calculates_the_base_price_from_value_price()
    {
        $product = factory(Product::class)->create([
            'unit' => 'kg',
            'volume' => 1,
            'volume_unit' => 'kg',
            'price' => 150,
            'price_unit' => 'kg',
        ]);

        $this->assertEquals(150, $product->price()->base());
    }

    /** @test */
    public function it_handles_the_rounding()
    {
        $product = factory(Product::class)->create([
            'unit' => 'portion',
            'volume' => 165,
            'volume_unit' => 'g',
            'price' => 299,
            'price_unit' => 'kg',
        ]);
        $this->assertEquals(49, $product->price()->value());
        $this->assertEquals(299, $product->price()->base());
    }
}
