<?php

namespace Marktstand\Payment;

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
