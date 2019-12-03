<?php

use Marktstand\Checkout\Cart\Cart;
use Marktstand\Checkout\Cart\Item;
use Marktstand\Product\Product;
use Marktstand\Users\Producer;
use Marktstand\Users\Supplier;

$factory->define(Item::class, function () {
    return [
       'cart_id' => function () {
           return factory(Cart::class)->create()->id;
       },

       'product_id' => function () {
           return factory(Product::class)->create()->id;
       },

       'producer_id' => function () {
           $producer = Producer::first();

           return $producer ?: factory(Producer::class)->create()->id;
       },

       'supplier_id' => function () {
           $supplier = Supplier::first();

           return $supplier ?: factory(Supplier::class)->create()->id;
       },

       'quantity' => 1,
    ];
});
