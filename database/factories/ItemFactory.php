<?php

use Marktstand\Checkout\Cart;
use Marktstand\Checkout\Item;
use Marktstand\Product\Product;

$factory->define(Item::class, function () {
    return [
        'quantity' => 5000,
        'product_id' => function() {
            return factory(Product::class)->create()->id;
        },
        'checkout_id' => function() {
            return factory(Cart::class)->create()->id;
        },
        'checkout_type' => 'cart'
    ];
});