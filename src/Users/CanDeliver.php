<?php

namespace Marktstand\Users;

trait CanDeliver
{
    /**
     * Get the models image.
     */
    public function supplier()
    {
        return $this->morphOne(Supplier::class, 'user');
    }
}
