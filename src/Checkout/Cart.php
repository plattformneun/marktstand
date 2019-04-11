<?php

namespace Marktstand\Checkout;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
     * Get the items.
     */
    public function items()
    {
        return $this->morphMany(Item::class, 'checkout');
    }
}
