<?php

namespace Marktstand\Users;

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
     * @return boolean
     */
    public function hasBankAccounts()
    {
        return !! $this->user->bankAccounts()->count();
    }

    /**
     * Check if the user is verified.
     * 
     * @return boolean
     */
    public function isVerified()
    {
        return $this->user->isVerified();
    }
}
