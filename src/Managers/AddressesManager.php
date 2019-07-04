<?php

namespace Marktstand\Managers;

use Marktstand\Support\Address;

trait AddressesManager
{
    /**
     * Add a new address.
     *
     * @param object $owner
     * @param array $data
     * @return bool
     */
    public function addAddress($owner, array $data)
    {
        $address = new Address;

        $this->makeAddressFillable($address)->fill(array_merge($data, [
            'owner_id' => $owner->id,
            'owner_type' => $owner->type,
        ]))->save();

        return $address;
    }

    /**
     * Set fillable fields for the given bank account.
     *
     * @param  Marktstand\Support\Address $address
     * @return Marktstand\Support\Address
     */
    public function makeAddressFillable(Address $address)
    {
        return $this->setFillable($address, [
            'recipient', 'street', 'house', 'post_code', 'city', 'country', 'owner_id', 'owner_type',
        ]);
    }
}
