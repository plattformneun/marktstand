<?php

namespace Marktstand\Managers;

use Marktstand\Support\Address;

class AddressesManager extends Manager
{
    /**
     * Add a new address.
     *
     * @param array $data
     * @param object $owner
     * @return bool
     */
    public function create(array $data, $owner)
    {
        $address = new Address;

        $this->makeFillable($address)->fill(array_merge($data, [
            'owner_id' => $owner->id,
            'owner_type' => $owner->type,
        ]))->save();

        return $address;
    }

    /**
     * Find an address by id.
     *
     * @param  int $id
     * @return Marktstand\Support\Address
     */
    public function fromId($id)
    {
        return Address::findOrFail($id);
    }

    /**
     * Get all addresses from the given owner.
     *
     * @param  object $owner
     * @return Illuminate\Support\Collection
     */
    public function fromOwner($owner)
    {
        return $owner->addresses;
    }

    /**
     * Update the given address.
     *
     * @param  Marktstand\Support\Address $address
     * @param  array $data
     * @return Marktstand\Support\Address
     */
    public function update(Address $address, array $data)
    {
        return $this->makeFillable($address)->update($data);
    }

    /**
     * Define the fillable fields.
     *
     * @return array
     */
    protected function fillable()
    {
        return [
            'recipient', 'street', 'house', 'post_code', 'city', 'country', 'owner_id', 'owner_type',
        ];
    }
}
