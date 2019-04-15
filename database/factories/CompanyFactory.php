<?php

use Marktstand\Company\Company;

$factory->define(Company::class, function () {
    return [
        'name' => 'My Company',
        'legal_form' => 'Ltd',
        'street' => 'Example Ave',
        'house' => '12a',
        'post_code' => '12345',
        'city' => 'Berlin',
        'country' => 'DE',
        'vat_id' => 'DE123456789',
        'user_id' => 1,
        'user_type' => 'customer'
    ];
});
