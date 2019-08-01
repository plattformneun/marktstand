<?php

namespace Marktstand;

use Marktstand\Managers\UsersManager;
use Marktstand\Managers\ImagesManager;
use Marktstand\Managers\CheckoutManager;
use Marktstand\Managers\ContactsManager;
use Marktstand\Managers\ProductsManager;
use Marktstand\Managers\AddressesManager;
use Marktstand\Managers\CompaniesManager;
use Marktstand\Managers\ProducersManager;
use Marktstand\Managers\SuppliersManager;
use Marktstand\Managers\BankAccountsManager;

class Marktstand
{
    /**
     * Get the addresses manager.
     *
     * @return Marktstand\Managers\AddressesManager
     */
    public function addresses()
    {
        return new AddressesManager;
    }

    /**
     * Get the bank account manager.
     *
     * @return Marktstand\Managers\BankAccountsManager
     */
    public function bankAccounts()
    {
        return new BankAccountsManager;
    }

    /**
     * Get the checkout manager.
     *
     * @return Marktstand\Managers\CheckoutManager
     */
    public function checkout()
    {
        return new CheckoutManager;
    }

    /**
     * Get the companies manager.
     *
     * @return Marktstand\Managers\CompaniesManager
     */
    public function companies()
    {
        return new CompaniesManager;
    }

    /**
     * Get the contacts manager.
     *
     * @return Marktstand\Managers\ContactsManager
     */
    public function contacts()
    {
        return new ContactsManager;
    }

    /**
     * Get the images manager.
     *
     * @return Marktstand\Managers\ImagesManager
     */
    public function images()
    {
        return new ImagesManager;
    }

    /**
     * Get the producers manager.
     *
     * @return Marktstand\Managers\ProducersManager
     */
    public function producers()
    {
        return new ProducersManager;
    }

    /**
     * Get the products manager.
     *
     * @return Marktstand\Managers\ProductsManager
     */
    public function products()
    {
        return new ProductsManager;
    }

    /**
     * Get the suppliers manager.
     *
     * @return Marktstand\Managers\SuppliersManager
     */
    public function suppliers()
    {
        return new SuppliersManager;
    }

    /**
     * Get the users manager.
     *
     * @return Marktstand\Managers\UsersManager
     */
    public function users()
    {
        return new UsersManager;
    }

    /**
     * Set fillable fields for the given model.
     *
     * @param  Illuminate\Database\Eloquent\Model $model
     * @param  array  $fillable
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function setFillable($model, array $fillable)
    {
        return $model->fillable($fillable);
    }
}
