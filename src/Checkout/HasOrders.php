<?php

namespace Marktstand\Checkout;

trait HasOrders
{
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
