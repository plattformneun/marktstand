<?php

use Marktstand\Users\Customer;

$factory->define(Customer::class, function () {
    return [
        'firstname' => 'Jane',
        'lastname' => 'Doe',
        'email' => 'johndoe@example.com',
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
    ];
});