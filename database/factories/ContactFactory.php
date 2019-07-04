<?php

use Marktstand\Company\Contact;

$factory->define(Contact::class, function () {
    return [
        'position'  => 'Owner',
        'gender'    => 'female',
        'firstname' => 'Jane',
        'lastname'  => 'Doe',
        'email'     => 'janedoe@example.com',
        'user_id'   => 1,
        'user_type' => 'customer',
    ];
});
