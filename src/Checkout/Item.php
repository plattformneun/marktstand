<?php

namespace Marktstand\Checkout;

use Marktstand\Product\Product;
use Marktstand\Contracts\Checkout;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * Get the product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the price.
     *
     * @return Marktstand\Product\Price
     */
    public function price()
    {
        return $this->product->price();
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

    public function transform(Checkout $checkout)
    {
        $this->unguard();
        $this->update([
            'checkout_id' => $checkout->id,
            'checkout_type' => $checkout->type,
        ]);
    }
}
