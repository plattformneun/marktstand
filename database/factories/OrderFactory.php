<?php

use Marktstand\Users\Customer;
use Marktstand\Users\Producer;
use Marktstand\Checkout\Order;

$factory->define(Order::class, function () {
    return [
        'customer_id' => function () {
            return factory(Customer::class)->create()->id;
        },
        'producer_id' => function () {
            return factory(Producer::class)->create()->id;
        },
    ];
});
