<?php

use Marktstand\Users\Producer;
use Marktstand\Product\Product;

$factory->define(Product::class, function () {
    return [
        'visibillity' => true,
        'title' => 'Kartoffeln',
        'unit' => 'kg',
        'volume' => 1,
        'volume_unit' => 'kg',
        'price' => '1500',
        'price_unit' => 'kg',
        'vat' => 7,
        'producer_id' => function () {
            $producer = Producer::first();
            return $producer ?: factory(Producer::class)->create()->id;
        },
        'lead_time' => 2
    ];
});
