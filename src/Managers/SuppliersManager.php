<?php

namespace Marktstand\Managers;

use Marktstand\Users\Supplier;

class SuppliersManager extends Manager
{
    /**
     * Create a new supplier.
     *
     * @param array $data
     * @param Illuminate\Foundation\Auth\User $user
     * @return Marktstand\Users\Supplier
     */
    public function create(array $data, $user)
    {
        $supplier = new Supplier;

        $this->makeFillable($supplier)->fill(array_merge($data, [
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
    public function update(Supplier $supplier, array $data)
    {
        $this->makeFillable($supplier)->update($data);

        return $supplier;
    }

    /**
     * Set the fillable fields.
     *
     * @return array
     */
    protected function fillable()
    {
        return [
            'charge', 'free_shipping_at', 'delivery_times', 'min_order_value', 'user_id', 'user_type',
        ];
    }
}
