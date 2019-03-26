<?php

namespace Marktstand\Access;

use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Marktstand\Events\UserVerified;
use Marktstand\Events\VerificationRequest;

trait Verifiable
{
    /**
     * Verify the user.
     * 
     * @return void
     */
    public function verify()
    {
        $this->verified_at = Carbon::now();
        $this->save();

        Event::dispatch(new UserVerified($this));
    }

    /**
     * Request to be verified.
     * 
     * @return void
     */
    public function requestVerification()
    {
        Event::dispatch(new VerificationRequest($this));
    }

    /**
     * Check if the user has been verified.
     * 
     * @return boolean
     */
    public function isVerified()
    {
        return !! $this->verified_at;
    }

}