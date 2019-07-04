<?php

namespace Marktstand\Managers;

use Marktstand\Users\Customer;
use Marktstand\Users\Producer;
use Marktstand\Users\Supplier;

trait UsersManager
{
    /**
     * Register a new customer.
     *
     * @param  array $data
     * @return Marktstand\Users\Customer
     */
    public function registerCustomer(array $data)
    {
        return $this->fillUser(new Customer, $data);
    }

    /**
     * Register a new producer.
     *
     * @param  array $data
     * @return Marktstand\Users\Producer
     */
    public function registerProducer(array $data)
    {
        return $this->fillUser(new Producer, $data);
    }

    /**
     * Fill a user with data.
     *
     * @param  Illuminate\Database\Eloquent\Model $user
     * @param  array $data
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
     * @param  array $data
     * @return Illuminate\Database\Eloquent\Model
     */
    public function updateUser($user, array $data)
    {
        $this->makeUserFillable($user)
            ->update($data);

        return $user;
    }

    /**
     * Add a new supplier.
     *
     * @param Illuminate\Foundation\Auth\User $user
     * @param array $data
     * @return Marktstand\Users\Supplier
     */
    public function addSupplier($user, array $data)
    {
        $supplier = new Supplier;

        $this->makeSupplierFillable($supplier)->fill(array_merge($data, [
            'user_id' => $user->id,
            'user_type' => $user->type,
        ]))->save();

        return $supplier;
    }

    /**
     * Update a supplier.
     *
     * @param Marktstand\Users\Supplier
     * @param array $data
     * @return Marktstand\Users\Supplier
     */
    public function updateSupplier(Supplier $supplier, array $data)
    {
        $this->makeSupplierFillable($supplier)->update($data);

        return $supplier;
    }

    /**
     * Set fillable fields for the given supplier.
     *
     * @param  Marktstand\Users\Supplier $supplier
     * @return Marktstand\Users\Supplier
     */
    public function makeSupplierFillable(Supplier $supplier)
    {
        return $this->setFillable($supplier, [
            'charge', 'free_shipping_at', 'delivery_times', 'min_order_value', 'user_id', 'user_type',
        ]);
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
            'email', 'firstname', 'lastname', 'password', 'username', 'options',
        ]);
    }
}
