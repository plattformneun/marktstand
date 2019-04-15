<?php

use Marktstand\Checkout\Order;
use Marktstand\Users\Customer;
use Marktstand\Users\Producer;

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
