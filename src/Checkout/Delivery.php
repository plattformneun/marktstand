<?php

namespace Marktstand\Checkout;

use Carbon;
use Illuminate\Support\Collection;

class Delivery
{
    /**
     * The items that should delivered.
     *
     * @var Illuminate\Http\Collection
     */
    protected $items;

    /**
     * Create a new delivery instance.
     *
     * @param Illuminate\Support\Collection $items
     */
    public function __construct($items)
    {
        $this->items = $items;
    }

    /**
     * Get the delivery days.
     *
     * @return Illuminate\Support\Collection
     */
    public function days($until)
    {
        $period = Carbon\CarbonPeriod::create(
            Carbon\Carbon::tomorrow(), $until
        );

        return Collection::make($period->toArray())->filter(function ($day) {
            return in_array($day->dayOfWeek, $this->supplier()->delivery_times);
        })->values();
    }

    /**
     * Check if minimum order value has been reached.
     *
     * @return bool
     */
    public function hasMinimumOrderValue()
    {
        return $this->supplier()->min_order_value <= $this->subtotal();
    }

    /**
     * Get the supplier.
     *
     * @return Marktstand\Users\Supplier
     */
    public function supplier()
    {
        return $this->items->first()->supplier;
    }

    /**
     * Get the producers.
     *
     * @return Illuminate\Support\Collection
     */
    public function items()
    {
        return $this->items->groupBy('producer_id')->values();
    }

    public function minimumOrderValue()
    {
        return $this->supplier()->min_order_value;
    }

    /**
     * Get the subtotal.
     *
     * @return int
     */
    public function subtotal()
    {
        return $this->items->sum('total');
    }

    /**
     * Get the shiiping fee.
     *
     * @return int
     */
    public function shipping()
    {
        if ($this->isFreeShipping()) {
            return 0;
        }

        return $this->supplier()->charge;
    }

    /**
     * Check if shipping is free.
     *
     * @return bool
     */
    public function isFreeShipping()
    {
        return $this->subtotal() >= $this->supplier()->free_shipping_at;
    }

    /**
     * Get the vat.
     *
     * @return Illuminate\Support\Collection
     */
    public function vat()
    {
        return $this->items->groupBy('vat')->map(function ($group) {
            return $group->map(function ($item) {
                return $item->total * $item->vat / 100;
            })->sum();
        });
    }
}
