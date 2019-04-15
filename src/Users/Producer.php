<?php

namespace Marktstand\Users;

use Illuminate\Foundation\Auth\User;
use Marktstand\Access\Verifiable;
use Marktstand\Checkout\HasOrders;
use Marktstand\Company\HasCompany;
use Marktstand\Payment\HasBankAccounts;
use Marktstand\Product\Product;
use Marktstand\Support\Reflectable;

class Producer extends User
{
    use HasBankAccounts, HasCompany, HasOrders, Reflectable, Verifiable;

    /**
     * @var string
     */
    public $type = 'producer';

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
