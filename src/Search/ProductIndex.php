<?php

namespace Marktstand\Search;

class ProductIndex extends Index
{
    /**
     * Get the indexable key.
     *
     * @return string
     */
    public function getKey()
    {
        return 'product:'.$this->id;
    }

    /**
     * Get the indexable attributes.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'title'    => $this->title,
            'producer' => $this->producer_name,
            'price'    => $this->total_price,
        ];
    }
}
