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
     * @var string
     */
    public $type = 'customer';

    /**
     * The customers cart.
     */
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    /**
     * Get the users state.
     * 
     * @return Marktstand\Users\State
     */
    public function state()
    {
        return new State($this);
    }
}
