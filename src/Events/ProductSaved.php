<?php

namespace Marktstand\Events;

use Illuminate\Queue\SerializesModels;
use Marktstand\Product\Product;

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
