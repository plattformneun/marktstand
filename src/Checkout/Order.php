<?php

namespace Marktstand\Checkout;

use Marktstand\Users\Customer;
use Marktstand\Users\Producer;
use Marktstand\Contracts\Checkout;
use Illuminate\Database\Eloquent\Model;

class Order extends Model implements Checkout
{
    use HasItems;

    /**
     * Create new orders from cart.
     *
     * @param  Cart   $cart
     * @return void
     */
    public static function createFromCart(Cart $cart)
    {
        $customerId = $cart->customer->id;

        $cart->itemsPerProducer()->each(function ($items, $producerId) use ($customerId) {
            self::unguard();

            $order = self::create([
                'customer_id' => $customerId,
                'producer_id' => $producerId,
            ]);

            $items->each(function ($item) use ($order) {
                $item->unguard();

                $item->transform($order);
            });
        });
    }

    /**
     * Get the customer.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the producer.
     */
    public function producer()
    {
        return $this->belongsTo(Producer::class);
    }

    /**
     * Get the checkout type.
     *
     * @return string
     */
    public function getTypeAttribute()
    {
        return 'order';
    }
}
