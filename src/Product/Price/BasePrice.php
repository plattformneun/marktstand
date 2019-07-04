<?php

namespace Marktstand\Product\Price;

class BasePrice extends Price
{
    /**
     * Get the price amount.
     *
     * @return int
     */
    public function amount()
    {
        if($this->isPiece()) {
            return $this->price / $this->canonicalizedVolume();
        }

        return $this->price / $this->factor($this->priceUnit);
    }

    /**
     * Get the price unit.
     *
     * @return string
     */
    public function unit()
    {
        if($this->isPiece()) {
            return $this->baseUnit($this->volumeUnit);
        }

        return $this->baseUnit($this->priceUnit);
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
     * Check if the products is an quantity article.
     *
     * @return bool
     */
    protected function isPiece()
    {
        return $this->priceUnit === 'pc';
    }
}