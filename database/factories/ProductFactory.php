<?php

use Marktstand\Product\Product;
use Marktstand\Users\Producer;

$factory->define(Product::class, function () {
    return [
        'title' => 'Rinderfilet',
        'unit' => 'portion',
        'volume' => 800,
        'volume_unit' => 'g',
        'price' => '1500',
        'price_unit' => 'kg',
        'vat' => 7,
        'producer_id' => function() {
            return factory(Producer::class)->create()->id;
        }
    ];
});
