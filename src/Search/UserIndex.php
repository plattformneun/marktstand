<?php

namespace Marktstand\Search;

class UserIndex extends Index
{
    /**
     * Get the indexable key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->type.':'.$this->id;
    }

    /**
     * Get the indexable attributes.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->company->toArray();
    }
}
