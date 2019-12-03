<?php

namespace Marktstand\Payment;

use Illuminate\Support\Facades\Config;
use Marktstand\Contracts\Price;

class Commission
{
    /**
     * @var int
     */
    protected $factor;

    /**
     * @var int
     */
    protected $price;

    /**
     * Create a new commission instance.
     */
    public function __construct($price)
    {
        $this->factor = Config::get('marktstand.commission');
        $this->price = $price;
    }

    /**
     * Get the factor.
     *
     * @return float
     */
    public function factor()
    {
        return $this->factor / 100;
    }

    /**
     * Get the commision value from price.
     *
     * @return int
     */
    public function value()
    {
        return (int) round($this->price * $this->factor());
    }

    /**
     * Get the total price including the commision.
     *
     * @return int
     */
    public function total()
    {
        return $this->price + $this->value();
    }

    /**
     * Subtract the commission from the given price.
     *
     * @param  int    $price
     * @return int
     */
    public static function subtract(int $price)
    {
        $commission = new static($price);

        return $price - $commission->value();
    }
}
