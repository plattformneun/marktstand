<?php

namespace Marktstand\Company;

trait HasContacts
{
    /**
     * Get the contacts.
     */
    public function contacts()
    {
        return $this->morphOne(Contact::class, 'user');
    }
}
