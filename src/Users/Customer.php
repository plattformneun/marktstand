<?php

namespace Marktstand\Users;

use Marktstand\Checkout\Cart;
use Marktstand\Product\Product;
use Marktstand\Support\Address;
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
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            (new Cart)->fillable(['customer_id'])
                ->fill(['customer_id' => $model->id])
                ->save();
        });
    }

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
     * Get the customers addresses.
     */
    public function addresses()
    {
        return $this->morphMany(Address::class, 'owner');
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

    /**
     * Get the customers favourite products.
     */
    public function favourites()
    {
        return $this->belongsToMany(Product::class, 'favourites');
    }
}
