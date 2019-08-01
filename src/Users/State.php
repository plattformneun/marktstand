<?php

namespace Marktstand\Users;

use Marktstand\Company\Company;
use Illuminate\Foundation\Auth\User;

class State
{
    /**
     * @var Illuminate\Foundation\Auth\User
     */
    protected $user;

    /**
     * Create a new state instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Check if the user has bank accounts.
     *
     * @return bool
     */
    public function hasBankAccounts()
    {
        return (bool) $this->user->bankAccounts()->count();
    }

    /**
     * Check if the user has a company.
     *
     * @return bool
     */
    public function hasCompany()
    {
        return $this->user->company instanceof Company;
    }

    /**
     * Check if the user has contacts.
     *
     * @return bool
     */
    public function hasContacts()
    {
        return (bool) $this->user->contacts()->count();
    }

    /**
     * Check if the users delivery options are set.
     *
     * @return bool
     */
    public function hasDeliveryOptions()
    {
        if ($this->user->type === 'customer') {
            return true;
        }

        return (bool) $this->user->options['supply'];
    }

    /**
     * Check if the users registration progress is complete.
     *
     * @return bool
     */
    public function complete()
    {
        return $this->hasCompany()
            && $this->hasContacts()
            && $this->hasBankAccounts()
            && $this->hasDeliveryOptions();
    }

    /**
     * Check if the users state is pending.
     *
     * @return bool
     */
    public function isPending()
    {
        if (isset($this->user->options['status'])) {
            return $this->user->options['status'] === 'pending';
        }

        return false;
    }

    /**
     * Check if the user is verified.
     *
     * @return bool
     */
    public function isVerified()
    {
        return $this->user->isVerified();
    }
}
