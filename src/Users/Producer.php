<?php

namespace Marktstand\Users;

use Illuminate\Foundation\Auth\User;
use Marktstand\Access\Verifiable;
use Marktstand\Payment\HasBankAccounts;
use Marktstand\Product\Product;

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
