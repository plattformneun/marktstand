<?php

namespace Marktstand\Product\Price;

use Marktstand\Exceptions\InvalidArgumentException;

class ProductPrice extends Price
{
    /**
     * Get the price amount.
     *
     * @return int
     */
    public function amount()
    {
        if ($this->unit === $this->priceUnit) {
            return $this->price;
        }

        if (!$this->isValid()) {
            throw new InvalidArgumentException();
        }

        return $this->canonicalizedVolume() * $this->product->basePrice()->amount();
    }

    /**
     * Get the price unit.
     *
     * @return string
     */
    public function unit()
    {
        return $this->unit;
    }

    /**
     * Get the canonicalized volume.
     *
     * @return int
     */
    protected function canonicalizedVolume()
    {
        return $this->volume / $this->factor($this->volumeUnit);
    }

    /**
     * Check if the price attributes are valid.
     *
     * @return bool
     */
    protected function isValid()
    {
        return $this->baseUnit($this->volumeUnit) === $this->baseUnit($this->priceUnit);
    }
}
