<?php

namespace Marktstand\Checkout;

use Marktstand\Users;
use Marktstand\Events;
use Marktstand\Contracts\Checkout;
use Illuminate\Database\Eloquent\Model;

class Order extends Model implements Checkout
{
    use HasItems;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => Events\OrderCreated::class,
        'updated' => Events\OrderUpdated::class,
    ];

    /**
     * Create new orders from cart.
     *
     * @param  Cart   $cart
     * @return void
     */
    public static function createFromCart(Cart $cart)
    {
        $cart->contents()->each(function ($values, $producer_id) use ($cart) {
            self::unguard();

            // create a new order for each producer.
            $order = self::create([
                'customer_id' => $cart->customer_id,
                'producer_id' => $producer_id,
            ]);

            // attach the items to the order.
            $values['items']->each(function ($item) use ($order) {
                $order->addItem($item);
            });
        });
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

    /**
     * Attach the given item to the order.
     *
     * @param Item $item
     */
    public function addItem(Item $item)
    {
        $item->transform($this);
    }

    /**
     * Get the customer.
     */
    public function customer()
    {
        return $this->belongsTo(Users\Customer::class);
    }

    /**
     * Get the producer.
     */
    public function producer()
    {
        return $this->belongsTo(Users\Producer::class);
    }

    /**
     * Get the total price of the order.
     * 
     * @return int
     */
    public function total()
    {
        return $this->items->sum('total');
    }
}
