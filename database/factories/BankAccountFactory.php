<?php

use Marktstand\Users\Producer;
use Marktstand\Payment\BankAccount;

$factory->define(BankAccount::class, function () {
    return [
        'holder' => 'John Doe',
        'number' => 'DE04500105178845643911',
        'user_id' => function () {
            return factory(Producer::class)->create()->id;
        },
        'user_type' => 'producer',
    ];
});
