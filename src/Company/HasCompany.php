<?php

namespace Marktstand\Company;

trait HasCompany
{
    /**
     * Get the company.
     */
    public function company()
    {
        return $this->morphOne(Company::class, 'user');
    }
}
