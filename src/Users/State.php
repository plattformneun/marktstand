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
     * @return bool
     */
    public function hasBankAccounts()
    {
        return (bool) $this->user->bankAccounts()->count();
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
