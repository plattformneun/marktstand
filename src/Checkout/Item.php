<?php

namespace Marktstand\Checkout;

use Illuminate\Database\Eloquent\Model;
use Marktstand\Contracts\Checkout;
use Marktstand\Payment\Commission;
use Marktstand\Product\Product;

class Item extends Model
{
    /**
     * Get the product items price.
     * 
     * @return int
     */
    public function getPriceAttribute()
    {
        return $this->quantity * $this->product->price()->value();
    }

    /**
     * Get the product items total price.
     * 
     * @return int
     */
    public function getTotalAttribute()
    {
        return $this->getTotalPrice();
    }

    /**
     * Get the checkout price.
     *
     * @return int
     */
    public function getTotalPrice()
    {
        $commission = new Commission($this->price);

        return $commission->total();
    }

    /**
     * Get the product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the products producer.
     *
     * @return Marktstand\Users\Producer
     */
    public function producer()
    {
        return $this->product->producer();
    }

    /**
     * Transform the item to the given checkout type.
     *
     * @param  Checkout $checkout
     * @return void
     */
    public function transform(Checkout $checkout)
    {
        $this->unguard();
        $this->update([
            'checkout_id' => $checkout->id,
            'checkout_type' => $checkout->type,
        ]);
    }
}
