<?php

namespace Marktstand\Product;

class Volume
{
    /**
     * The products volume.
     *
     * @var int
     */
    protected $volume;

    /**
     * The volume unit.
     *
     * @var string
     */
    protected $volumeUnit;

    /**
     * Create a new volume instance.
     *
     * @param Marktstand\Product\Product $product
     */
    public function __construct(Product $product)
    {
        $this->volume = $product->volume;
        $this->volumeUnit = $product->volume_unit;
    }

    /**
     * Get the volume qunatity.
     *
     * @return int
     */
    public function quantity()
    {
        return $this->volume;
    }

    /**
     * Get the volumes unit.
     *
     * @return string
     */
    public function unit()
    {
        return $this->volumeUnit;
    }
}
