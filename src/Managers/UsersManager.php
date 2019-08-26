<?php

namespace Marktstand\Managers;

use Marktstand\Users\Customer;
use Marktstand\Users\Producer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsersManager extends Manager
{
    /**
     * Get a user from credentials.
     *
     * @param  array  $credentials
     * @return Illuminate\Foundation\Auth\User
     *
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function fromCredentials(array $credentials)
    {
        $user = $this->fromUsername($credentials['email']);

        if (Hash::check($credentials['password'], $user->password)) {
            return $user;
        }

        throw new ModelNotFoundException;
    }

    /**
     * Get a user from username.
     *
     * @param  string  $username
     * @return Illuminate\Foundation\Auth\User
     *
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function fromUsername(string $username)
    {
        if ($producer = Producer::where('email', $username)->first()) {
            return $producer;
        }

        if ($customer = Customer::where('email', $username)->first()) {
            return $customer;
        }

        throw new ModelNotFoundException;
    }

    /**
     * Register a new customer.
     *
     * @param  array $data
     * @return Marktstand\Users\Customer
     */
    public function registerCustomer(array $data)
    {
        return $this->fill(new Customer, $data);
    }

    /**
     * Register a new producer.
     *
     * @param  array $data
     * @return Marktstand\Users\Producer
     */
    public function registerProducer(array $data)
    {
        return $this->fill(new Producer, $data);
    }

    /**
     * Fill a user with data.
     *
     * @param  Illuminate\Database\Eloquent\Model $user
     * @param  array $data
     * @return Illuminate\Database\Eloquent\Model
     */
    public function fill($user, array $data)
    {
        $this->makeFillable($user)->fill($data)->save();

        return $user;
    }

    /**
     * Update a user.
     *
     * @param  Illuminate\Database\Eloquent\Model $user
     * @param  array $data
     * @return Illuminate\Database\Eloquent\Model
     */
    public function update($user, array $data)
    {
        $this->makeFillable($user)->update($data);

        return $user;
    }

    /**
     * Set the fillable fields.
     *
     * @return array
     */
    protected function fillable()
    {
        return [
            'email', 'firstname', 'lastname', 'password', 'username', 'options',
        ];
    }
}
