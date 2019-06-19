<?php

namespace Marktstand\Users;

use Marktstand\Support\Slug;
use Marktstand\Product\Product;
use Marktstand\Product\Quality;
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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'type',
    ];

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
     * Query the qualities.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function qualities()
    {
        return $this->morphToMany(Quality::class, 'qualifyable');
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
