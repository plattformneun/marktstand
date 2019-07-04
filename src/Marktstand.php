<?php

namespace Marktstand;

use Marktstand\Managers\AddressesManager;
use Marktstand\Managers\BankAccountsManager;
use Marktstand\Managers\CheckoutManager;
use Marktstand\Managers\CompaniesManager;
use Marktstand\Managers\ContactsManager;
use Marktstand\Managers\ImagesManager;
use Marktstand\Managers\ProductsManager;
use Marktstand\Managers\SettingsManager;
use Marktstand\Managers\UsersManager;

class Marktstand
{
    use AddressesManager,
        BankAccountsManager,
        CheckoutManager,
        CompaniesManager,
        ContactsManager,
        ImagesManager,
        ProductsManager,
        SettingsManager,
        UsersManager;

    /**
     * Set fillable fields for the given model.
     *
     * @param Illuminate\Database\Eloquent\Model $model
     * @param array                              $fillable
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function setFillable($model, array $fillable)
    {
        return $model->fillable($fillable);
    }
}
