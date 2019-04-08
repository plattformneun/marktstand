<?php

namespace Marktstand\Users;

use Marktstand\Checkout\Cart;
use Marktstand\Access\Verifiable;
use Marktstand\Support\Reflectable;
use Illuminate\Foundation\Auth\User;
use Marktstand\Payment\HasBankAccounts;

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
