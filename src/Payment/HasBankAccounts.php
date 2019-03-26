<?php

namespace Marktstand\Payment;

use Marktstand\Payment\BankAccount;

trait HasBankAccounts
{
    /**
     * Get the users bank accounts.
     */
    public function bankAccounts()
    {
       return $this->morphMany(BankAccount::class, 'user');
    }
}
