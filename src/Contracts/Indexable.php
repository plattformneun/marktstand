<?php

namespace Marktstand\Contracts;

use JsonSerializable;

interface Indexable extends JsonSerializable
{
    /**
     * Get the index key.
     *
     * @return string
     */
    public function getKey();

    /**
     * Get the array representation of the indexable entity.
     *
     * @return array
     */
    public function toArray();
}
