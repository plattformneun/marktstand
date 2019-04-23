<?php

namespace Marktstand\Checkout;

use Marktstand\Users\Customer;
use Marktstand\Contracts\Checkout;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model implements Checkout
{
    use HasItems;

    /**
     * Get the checkout type.
     *
     * @return string
     */
    public function getTypeAttribute()
    {
        return 'cart';
    }

    /**
     * Get the carts owner.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the cart items grouped by producer.
     *
     * @return Illuminate\Support\Collection
     */
    public function itemsPerProducer()
    {
        return $this->items->groupBy(function ($item) {
            return $item->producer->id;
        });
    }
}
