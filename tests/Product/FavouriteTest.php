<?php

namespace Marktstand\Tests\Product;

use Marktstand\Tests\TestCase;
use Marktstand\Users\Customer;
use Marktstand\Product\Product;
use Marktstand\Product\Favourite;

class FavouriteTest extends TestCase
{
    /** @test */
    public function a_product_may_be_favored()
    {
        $customer = factory(Customer::class)->create();
        $product = factory(Product::class)->create();

        Favourite::forceCreate([
            'customer_id' => $customer->id,
            'product_id' => $product->id,
        ]);

        $this->assertCount(1, $customer->favourites);
    }

    /** @test */
    public function a_product_may_be_favored_by_shorthand()
    {
        $customer = factory(Customer::class)->create();
        $product = factory(Product::class)->create();

        Favourite::forceCreate([
            'customer' => $customer,
            'product' => $product,
        ]);

        $this->assertCount(1, $customer->favourites);
    }
}
