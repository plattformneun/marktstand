<?php

use Marktstand\Product\Category;

$factory->define(Category::class, function () {
    return [
        'title' => 'Vegetables',
        'slug' => 'vegetables',
    ];
});
