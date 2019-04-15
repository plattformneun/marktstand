<?php

namespace Marktstand\Contracts;

interface Checkout
{
    /**
     * Get the checkout type.
     *
     * @return string
     */
    public function getTypeAttribute();
}
