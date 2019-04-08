<?php

namespace Marktstand\Users;

use Marktstand\Product\Product;
use Marktstand\Access\Verifiable;
use Marktstand\Support\Reflectable;
use Illuminate\Foundation\Auth\User;
use Marktstand\Payment\HasBankAccounts;

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
