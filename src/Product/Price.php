<?php

namespace Marktstand\Product;

use Illuminate\Support\Facades\Config;
use Marktstand\Exceptions\InvalidArgumentException;

class Price
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
     * Get the price value from base.
     * 
     * @return integer
     */
    public function base()
    {
        if($this->product->unit->type() === $this->unit()->type()) {
            return (int) round($this->product->price / $this->product->volume()->value() * $this->product->volume()->unit()->factor());
        }

        return (int) round($this->product->price / $this->unit()->factor());
    }

    /**
     * Get the price unit.
     * 
     * @return Marktstand\Support\Unit
     */
    public function unit()
    {
        return $this->product->price_unit;
    }

    /**
     * Get the products price.
     * 
     * @return integer
     */
    public function value()
    {
        if($this->product->unit->type() === $this->unit()->type()) {
            return $this->product->price;
        }

        if($this->product->volume()->unit()->base() !== $this->unit()->base()) {
            throw new InvalidArgumentException('The price unit does not match the product unit.');
        }

        return (int) round($this->product->volume()->base() * $this->base());
    }
}
