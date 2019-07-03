<?php

namespace Marktstand\Support;

class Vat implements \JsonSerializable
{
    /**
     * @var int
     */
    protected $factor;

    /**
     * @var int
     */
    protected $value;

    /**
     * Create a new vat instance.
     */
    public function __construct(int $value, int $factor)
    {
        $this->value = $value;
        $this->factor = $factor;
    }

    public function value()
    {
        return intval(round($this->value * $this->factor / 100));
    }

    public function factor()
    {
        return $this->factor;
    }

    public function toArray()
    {
        return [
            $this->factor() => $this->value()
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
