<?php

namespace Marktstand\Product;

use Illuminate\Support\Facades\Config;
use Marktstand\Exceptions\InvalidArgumentException;

class Volume
{
    /**
     * @var Marktstand\Product\Product
     */
    protected $product;

    /**
     * Create a new price instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get the volume from base.
     * 
     * @return Number
     */
    public function base()
    {
        return $this->value() / $this->unit()->factor();
    }

    /**
     * Get the volume unit.
     * 
     * @return Marktstand\Support\Unit
     */
    public function unit()
    {
        return $this->product->volume_unit;
    }

    /**
     * Get the value.
     * 
     * @return integer
     */
    public function value()
    {
        return $this->product->volume;
    }
}
