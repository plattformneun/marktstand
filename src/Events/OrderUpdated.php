<?php

namespace Marktstand\Events;

use Illuminate\Queue\SerializesModels;
use Marktstand\Checkout\Order;

class OrderUpdated
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
