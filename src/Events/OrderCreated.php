<?php

namespace Marktstand\Events;

use Marktstand\Checkout\Order;
use Illuminate\Queue\SerializesModels;

class OrderCreated
{
    use SerializesModels;

    /**
     * @var Marktstand\Checkout\Order
     */
    public $order;

    /**
     * Create a new event instance.
     *
     * @param Marktstand\Checkou\Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
