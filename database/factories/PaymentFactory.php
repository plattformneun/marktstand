<?php

use Marktstand\Users\Customer;
use Marktstand\Users\Supplier;

$factory->define(Supplier::class, function () {
    return [
        'user_id' => function () {
            $customer = Customer::first();

            return $customer ?: factory(Customer::class)->create()->id;
        },
        'user_type' => 'customer',
        'delivery_id' => 1,
        'amount' => 55000,
    ];
});
