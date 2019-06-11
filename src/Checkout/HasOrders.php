<?php

namespace Marktstand\Checkout;

trait HasOrders
{
    /**
     * The users orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
