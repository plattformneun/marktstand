<?php

namespace Marktstand\Checkout;

use Marktstand\Users\Customer;
use Marktstand\Users\Producer;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
     * Get the carts owner.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the cart items.
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the deliveries.
     *
     * @return Illuminate\Support\Collection
     */
    public function getDeliveriesAttribute()
    {
        $items = $this->items;

        $this->producers = $this->producers(
            $items->pluck('producer_id')->unique()->toArray()
        );

        return $items->groupBy('supplier_id')->map(function ($group) {
            return new Delivery($group, $this->producers);
        })->values();
    }

    /**
     * Filter the deliveries.
     *
     * @return Illuminate\Support\Collection
     */
    public function processable()
    {
        return $this->deliveries->filter->hasMinimumOrderValue();
    }

    /**
     * Get the producers of the cart items.
     *
     * @param  array  $ids
     * @return Illuminate\Support\Collection
     */
    public function producers(array $ids)
    {
        return Producer::with([
            'company',
            'supplier',
            'supplier.user.company',
            'supplier.user.company.logo',
        ])->findMany($ids);
    }

    /**
     * Get the shipping.
     *
     * @return int
     */
    public function shipping()
    {
        return $this->processable()->sum->shipping();
    }

    /**
     * Get the subtotal.
     *
     * @return int
     */
    public function subtotal()
    {
        return $this->processable()->sum->subtotal();
    }

    /**
     * Get the total amount.
     *
     * @return int
     */
    public function total()
    {
        return $this->subtotal() + $this->shipping() + $this->vat()->sum();
    }

    /**
     * Get the vat.
     *
     * @return Illuminate\Support\Collection
     */
    public function vat()
    {
        return $this->processable()->flatMap(function ($delivery) {
            return $this->transformVat($delivery->vat());
        })->groupBy('factor')->map->sum('amount');
    }

    /**
     * Transform the vat.
     *
     * @param  Illuminate\Support\Collection $vat
     * @return Illuminate\Support\Collection
     */
    protected function transformVat($vat)
    {
        return $vat->map(function ($amount, $factor) {
            return [
                'factor' => $factor,
                'amount' => $amount,
            ];
        });
    }
}
