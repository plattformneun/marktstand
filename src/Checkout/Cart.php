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
     * Get the cart content.
     *
     * @return Illuminate\Support\Collection
     */
    public function contents()
    {
        return $this->items->groupBy(function ($item) {
            return $item->producer->id;
        })->map(function ($items) {
            return [
                'items' => $items,
                'total' => $items->sum('total'),
            ];
        });
    }
}
