<?php

namespace Marktstand\Users;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Marktstand\Access\Verifiable;
use Marktstand\Checkout\HasOrders;
use Marktstand\Company\HasCompany;
use Marktstand\Company\HasContacts;
use Marktstand\Payment\HasBankAccounts;
use Marktstand\Product\Product;
use Marktstand\Support\Reflectable;
use Marktstand\Support\Slug;

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
        'password'
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
     * Set the users password.
     *
     * @param string $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Set the username.
     *
     * @param string $value
     * @return  void
     */
    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = (string) new Slug($value);
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
