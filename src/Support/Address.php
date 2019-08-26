<?php

namespace Marktstand\Support;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * Get the owners.
     */
    public function owners()
    {
        return $this->morphTo();
    }
}
