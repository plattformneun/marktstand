<?php

namespace Marktstand\Users;

use Marktstand\Checkout\Cart;
use Marktstand\Access\Verifiable;
use Marktstand\Checkout\HasOrders;
use Marktstand\Company\HasCompany;
use Marktstand\Company\HasContacts;
use Marktstand\Support\Reflectable;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Marktstand\Payment\HasBankAccounts;

class Customer extends User
{
    use HasBankAccounts,
        HasCompany,
        HasContacts,
        HasOrders,
        Reflectable,
        Verifiable;

    /**
     * Get the user type.
     *
     * @return string
     */
    public function getTypeAttribute()
    {
        return 'customer';
    }

    /**
     * Set the users password.
     *
     * @param string $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

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
