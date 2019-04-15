<?php

namespace Marktstand\Checkout;

trait HasItems
{
    /**
     * Get the items.
     */
    public function items()
    {
        return $this->morphMany(Item::class, 'checkout');
    }
}
