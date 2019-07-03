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
     * The producers that may own the the items.
     *
     * @var Illuminate\Support\Collection
     */
    protected $producers;

    /**
     * Create a new delivery instance.
     *
     * @param Illuminate\Support\Collection $items
     * @param Illuminate\Support\Collection $producers
     */
    public function __construct($items, $producers)
    {
        $this->items = $items;
        $this->producers = $producers;
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

        return Collection::make($period->toArray())->filter(function($day) {
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
    public function producers()
    {
        $ids = $this->items->pluck('producer_id')->unique()->toArray();

        return $this->producers->filter(function($producer) use ($ids) {
            return in_array($producer->id, $ids);
        })->map(function($producer) {
            $producer->items = $this->items->filter(function($item) use ($producer) {
                return $item->producer->id === $producer->id;
            });

            return $producer;
        });
    }

    /**
     * Get the subtotal.
     *
     * @return integer
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
        if($this->isFreeShipping()) {
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
        return $this->items->groupBy('vat')->map(function($group) {
            return $group->map(function($item) {
                return $item->total * $item->vat / 100;
            })->sum();
        });
    }
}
