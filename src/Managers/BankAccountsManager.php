<?php

namespace Marktstand\Managers;

use Illuminate\Foundation\Auth\User;
use Marktstand\Payment\BankAccount;

class BankAccountsManager extends Manager
{
    /**
     * Create a new bank account.
     *
     * @param array $data
     * @param  Illuminate\Foundation\User $user
     * @return bool
     */
    public function create(array $data, User $user)
    {
        return $this->makeFillable(new BankAccount)->fill(array_merge($data, [
            'user_id' => $user->id,
            'user_type' => $user->type,
        ]))->save();
    }

    /**
     * Get the users bank accounts.
     *
     * @return Illuminate\Support\Collection
     */
    public function fromUser(User $user)
    {
        return $user->bankAccounts()->latest()->get();
    }

    /**
     * Define the fillable fields.
     *
     * @return array
     */
    protected function fillable()
    {
        return [
            'holder', 'number', 'code', 'user_id', 'user_type',
        ];
    }
}
