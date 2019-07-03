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

    /**
     * Get the company name.
     *
     * @return string
     */
    public function getCompanyNameAttribute()
    {
        if ($this->company) {
            return $this->company->name;
        }
    }
}
