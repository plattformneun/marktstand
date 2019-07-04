<?php

namespace Marktstand;

use Marktstand\Managers\UsersManager;
use Marktstand\Managers\ImagesManager;
use Marktstand\Managers\CheckoutManager;
use Marktstand\Managers\ContactsManager;
use Marktstand\Managers\ProductsManager;
use Marktstand\Managers\SettingsManager;
use Marktstand\Managers\AddressesManager;
use Marktstand\Managers\CompaniesManager;
use Marktstand\Managers\BankAccountsManager;

class Marktstand
{
    use AddressesManager,
        CheckoutManager,
        CompaniesManager,
        ImagesManager,
        ProductsManager,
        SettingsManager,
        UsersManager;

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
