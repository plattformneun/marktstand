<?php

namespace Marktstand\Company;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * Get the company owner.
     */
    public function user()
    {
        return $this->morphTo();
    }
}
