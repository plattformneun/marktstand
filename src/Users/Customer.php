<?php

namespace Marktstand\Users;

use Illuminate\Foundation\Auth\User;
use Marktstand\Access\Verifiable;
use Marktstand\Checkout\Cart;
use Marktstand\Checkout\HasOrders;
use Marktstand\Company\HasCompany;
use Marktstand\Payment\HasBankAccounts;
use Marktstand\Support\Reflectable;

class Customer extends User
{
    use HasBankAccounts, HasCompany, HasOrders, Reflectable, Verifiable;

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
