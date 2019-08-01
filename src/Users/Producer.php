<?php

namespace Marktstand\Users;

use Marktstand\Support\Slug;
use Marktstand\Product\Product;
use Marktstand\Product\Quality;
use Marktstand\Access\Verifiable;
use Marktstand\Company\HasCompany;
use Marktstand\Events\UserCreated;
use Marktstand\Company\HasContacts;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use Marktstand\Payment\HasBankAccounts;

class Producer extends User
{
    use CanDeliver,
        HasBankAccounts,
        HasCompany,
        HasContacts,
        Verifiable;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
    ];

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
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            Event::dispatch(new UserCreated($this));
        });
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
