<?php

use Marktstand\Users\Customer;
use Marktstand\Checkout\Cart\Cart;

$factory->define(Cart::class, function () {
    return [
        'customer_id' => function () {
            return factory(Customer::class)->create()->id;
        },
    ];
});
