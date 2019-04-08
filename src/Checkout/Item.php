<?php

namespace Marktstand\Checkout;

use Marktstand\Product\Product;
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
}
