<?php

namespace Marktstand\Events;

use Illuminate\Foundation\Auth\User;
use Illuminate\Queue\SerializesModels;

class VerificationRequest
{
    use SerializesModels;

    /**
     * @var Illuminate\Foundation\Auth\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param Illuminate\Foundation\Auth\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
