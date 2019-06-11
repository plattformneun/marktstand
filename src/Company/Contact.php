<?php

namespace Marktstand\Company;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * Get the company owner.
     */
    public function user()
    {
        return $this->morphTo();
    }
}
