<?php

namespace Marktstand\Product\Price;

use Marktstand\Product\Product;
use Marktstand\Payment\Commission;
use Illuminate\Support\Facades\Config;

abstract class Price
{
    /**
     * The unit configurations.
     *
     * @var array
     */
    protected $config;

    /**
     * The products unit.
     *
     * @var string
     */
    protected $unit;

    /**
     * The products volume.
     *
     * @var int
     */
    protected $volume;

    /**
     * The products volume unit.
     *
     * @var string
     */
    protected $volumeUnit;

    /**
     * The products price.
     *
     * @var int
     */
    protected $price;

    /**
     * The products price unit.
     *
     * @var string
     */
    protected $priceUnit;

    /**
     * The product.
     *
     * @var Marktstand\Product\Product
     */
    protected $product;

    /**
     * Create a new price instance.
     *
     * @param Marktstand\Product\Product $product
     */
    public function __construct(Product $product)
    {
        $this->unit = $product->unit;
        $this->volume = $product->volume;
        $this->volumeUnit = $product->volume_unit;
        $this->price = $product->price;
        $this->priceUnit = $product->price_unit;
        $this->product = $product;
    }

    /**
     * Get the price amount.
     *
     * @return int
     */
    abstract public function amount();

    /**
     * Get the price unit.
     *
     * @return string
     */
    abstract public function unit();

    /**
     * Add commission to the amount
     *
     * @return int
     */
    public function total()
    {
        $commission = new Commission($this->amount());
        return $commission->total();
    }

    /**
     * Fetch the base for the given unit.
     *
     * @param  string $unit
     * @return string
     */
    protected function baseUnit($unit)
    {
        return $this->config($unit, 'base');
    }

    /**
     * Fetch the factor for the given unit.
     *
     * @param  string $unit
     * @return int
     */
    protected function factor($unit)
    {
        return $this->config($unit, 'factor');
    }

    /**
     * Get the units config and store it on the object.
     *
     * @return mixed
     */
    protected function config(string $unit, string $key)
    {
        if (! $this->config) {
            $this->config = Config::get('marktstand.units');
        }

        return $this->config[$unit][$key];
    }
}