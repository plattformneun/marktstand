<?php

use Marktstand\Checkout\Cart\Cart;
use Marktstand\Users\Customer;

$factory->define(Cart::class, function () {
    return [
        'customer_id' => function () {
            return factory(Customer::class)->create()->id;
        },
    ];
});
