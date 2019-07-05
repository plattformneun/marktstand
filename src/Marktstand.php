<?php

namespace Marktstand;

use Marktstand\Managers\AddressesManager;
use Marktstand\Managers\BankAccountsManager;
use Marktstand\Managers\CheckoutManager;
use Marktstand\Managers\CompaniesManager;
use Marktstand\Managers\ContactsManager;
use Marktstand\Managers\ImagesManager;
use Marktstand\Managers\ProducersManager;
use Marktstand\Managers\ProductsManager;
use Marktstand\Managers\SettingsManager;
use Marktstand\Managers\UsersManager;

class Marktstand
{
    use CheckoutManager,
        CompaniesManager,
        ImagesManager,
        SettingsManager,
        UsersManager;

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
     * Get the contacts manager.
     *
     * @return Marktstand\Managers\ContactsManager
     */
    public function contacts()
    {
        return new ContactsManager;
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
