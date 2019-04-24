<?php

namespace Marktstand;

class Marktstand
{
    /**
     * Register a new customer.
     * @param  array  $data
     *
     * @return Marktstand\Users\Customer
     */
    public function registerCustomer(array $data)
    {
        return $this->fillUser(new Users\Customer, $data);
    }

    /**
     * Register a new producer.
     * @param  array  $data
     *
     * @return Marktstand\Users\Producer
     */
    public function registerProducer(array $data)
    {
        return $this->fillUser(new Users\Producer, $data);
    }

    /**
     * Fill a user with data.
     *
     * @param  Illuminate\Database\Eloquent\Model $user
     * @param  array  $data
     * @return Illuminate\Database\Eloquent\Model
     */
    public function fillUser($user, array $data)
    {
        $this->makeUserFillable($user)
            ->fill($data)
            ->save();

        return $user;
    }

    /**
     * Update a user.
     *
     * @param  Illuminate\Database\Eloquent\Model $user
     * @param  array  $data
     * @return Illuminate\Database\Eloquent\Model
     */
    public function updateUser($user, array $data)
    {
        $this->makeUserFillable($user)
            ->update($data);

        return $user;
    }

    /**
     * Add a new bank account.
     *
     * @param Illuminate\Foundation\Auth\User $user
     * @param array  $data
     * @return bool
     */
    public function addBankAccount($user, array $data)
    {
        return $this->makeBankAccountFillable(new Payment\BankAccount)->fill(array_merge($data, [
            'user_id' => $user->id,
            'user_type' => $user->type,
        ]))->save();
    }

    /**
     * Set fillable fields for the given user.
     *
     * @param  Illuminate\Database\Eloquent\Model $user
     * @return Illuminate\Database\Eloquent\Model
     */
    public function makeUserFillable($user)
    {
        return $this->setFillable($user, [
            'email', 'firstname', 'lastname', 'password',
        ]);
    }

    /**
     * Set fillable fields for the given bank account.
     *
     * @param  Marktstand\Payment\BankAccount $account
     * @return Marktstand\Payment\BankAccount
     */
    public function makeBankAccountFillable($account)
    {
        return $this->setFillable($account, [
            'holder', 'number', 'code', 'user_id', 'user_type',
        ]);
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
