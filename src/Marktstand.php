<?php

namespace Marktstand;

use Marktstand\Users;

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
     * Set fillable fields for the given user.
     *
     * @param  Illuminate\Database\Eloquent\Model $user
     * @param  array  $fillable
     * @return Illuminate\Database\Eloquent\Model
     */
    public function makeUserFillable($user, array $fillable)
    {
        return $this->setFillable($user, [
            'email', 'firstname', 'lastname', 'password',
        ]);
    }

    /**
     * Set fillable fields for the given model.
     *
     * @param  Illuminate\Database\Eloquent\Model $user
     * @param  array  $fillable
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function setFillable($model, array $fillable)
    {
        return $model->fillable($fillable);
    }
}
