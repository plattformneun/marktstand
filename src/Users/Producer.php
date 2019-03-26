<?php

namespace Marktstand\Users;

use Marktstand\Product\Product;
use Marktstand\Access\Verifiable;
use Illuminate\Foundation\Auth\User;
use Marktstand\Payment\HasBankAccounts;

class Producer extends User
{
    use HasBankAccounts, Verifiable;

    /**
     * Get the producers products.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
