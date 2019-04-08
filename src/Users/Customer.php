<?php

namespace Marktstand\Users;

use Illuminate\Foundation\Auth\User;
use Marktstand\Access\Verifiable;
use Marktstand\Checkout\Cart;
use Marktstand\Payment\HasBankAccounts;
use Marktstand\Support\Reflectable;

class Customer extends User
{
    use HasBankAccounts, Reflectable, Verifiable;

    /**
     * The customers cart.
     */
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
}
