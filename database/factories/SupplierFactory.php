<?php

use Marktstand\Users\Producer;
use Marktstand\Users\Supplier;

$factory->define(Supplier::class, function () {
    return [
        'user_id' => function () {
            $producer = Producer::first();

            return $producer ?: factory(Producer::class)->create()->id;
        },
        'user_type' => 'producer',
        'charge' => 1000,
        'min_order_value' => 10000,
        'free_shipping_at' => 30000,
        'delivery_times' => [1, 2],
    ];
});
