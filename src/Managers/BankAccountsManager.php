<?php

namespace Marktstand\Managers;

use Marktstand\Payment\BankAccount;

trait BankAccountsManager
{
    /**
     * Add a new bank account.
     *
     * @param Illuminate\Foundation\Auth\User $user
     * @param array                           $data
     *
     * @return bool
     */
    public function addBankAccount($user, array $data)
    {
        return $this->makeBankAccountFillable(new BankAccount())->fill(array_merge($data, [
            'user_id'   => $user->id,
            'user_type' => $user->type,
        ]))->save();
    }

    /**
     * Set fillable fields for the given bank account.
     *
     * @param Marktstand\Payment\BankAccount $account
     *
     * @return Marktstand\Payment\BankAccount
     */
    public function makeBankAccountFillable(BankAccount $account)
    {
        return $this->setFillable($account, [
            'holder', 'number', 'code', 'user_id', 'user_type',
        ]);
    }
}
