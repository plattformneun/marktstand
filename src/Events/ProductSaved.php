<?php

namespace Marktstand\Events;

use Marktstand\Product\Product;
use Illuminate\Queue\SerializesModels;

class ProductSaved
{
    use SerializesModels;

    /**
     * @var Marktstand\Product\Product
     */
    public $product;

    /**
     * Create a new event instance.
     *
     * @param Marktstand\Product\Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
}
