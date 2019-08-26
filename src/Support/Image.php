<?php

namespace Marktstand\Support;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * Get all of the owning imageable models.
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
