<?php

namespace Marktstand\Payment;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    /**
     * Get the bank account number.
     * 
     * @param  string $value
     * @return Marktstand\Payment\BankAccountNumber
     */
    public function getNumberAttribute($value)
    {
        return new BankAccountNumber($value);
    }

    /**
     * Set the bank account number.
     * 
     * @param string $value
     * @return  void
     */
    public function setNumberAttribute($value)
    {
        $this->attributes['number'] = (string) new BankAccountNumber($value);
    }

    /**
     * Get the bank account code.
     * 
     * @param  string $value
     * @return Marktstand\Payment\BankAccountCode
     */
    public function getCodeAttribute($value)
    {
        if($value) {
            return new BankAccountCode($value);
        }
    }

    /**
     * Set the bank account code.
     * 
     * @param string $value
     */
    public function setCodeAttribute($value)
    {
        if($value) {
            $this->attributes['code'] = (string) new BankAccountCode($value);
        }
    }

    /**
     * Get the owning model.
     */
    public function user()
    {
        return $this->morphTo();
    }
}
