<?php

use Marktstand\Checkout\Cart;
use Marktstand\Users\Producer;
use Marktstand\Users\Supplier;
use Marktstand\Product\Product;
use Marktstand\Checkout\CartItem;

$factory->define(CartItem::class, function () {
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
