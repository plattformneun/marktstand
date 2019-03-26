<?php

namespace Marktstand\Events;

use Illuminate\Foundation\Auth\User;
use Illuminate\Queue\SerializesModels;

class UserVerified
{
    use SerializesModels;

    /**
     * @var Illuminate\Foundation\Auth\User
     */
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}