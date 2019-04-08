<?php

namespace Marktstand\Users;

use Illuminate\Foundation\Auth\User;
use Marktstand\Access\Verifiable;
use Marktstand\Payment\HasBankAccounts;
use Marktstand\Product\Product;
use Marktstand\Support\Reflectable;

class Producer extends User
{
    use HasBankAccounts, Reflectable, Verifiable;

    /**
     * Get the producers products.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
