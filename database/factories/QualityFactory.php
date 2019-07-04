<?php

use Marktstand\Product\Quality;

$factory->define(Quality::class, function () {
    return [
        'title' => 'Organic',
        'slug'  => 'organic',
    ];
});
