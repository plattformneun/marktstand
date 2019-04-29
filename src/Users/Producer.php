<?php

namespace Marktstand\Users;

use Marktstand\Product\Product;
use Marktstand\Access\Verifiable;
use Marktstand\Checkout\HasOrders;
use Marktstand\Company\HasCompany;
use Marktstand\Company\HasContacts;
use Marktstand\Support\Reflectable;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Marktstand\Payment\HasBankAccounts;

class Producer extends User
{
    use HasBankAccounts,
        HasCompany,
        HasContacts,
        HasOrders,
        Reflectable,
        Verifiable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the user type.
     *
     * @return string
     */
    public function getTypeAttribute()
    {
        return 'producer';
    }

    /**
     * Get the producers company name.
     *
     * @return string
     */
    public function getShopNameAttribute()
    {
        if ($this->company) {
            return $this->company->name;
        }
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
     * Get the producers products.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
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
