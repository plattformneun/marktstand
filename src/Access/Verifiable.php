<?php

namespace Marktstand\Access;

use Carbon\Carbon;
use Marktstand\Events\UserVerified;
use Illuminate\Support\Facades\Event;
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
     * @return bool
     */
    public function isVerified()
    {
        return (bool) $this->verified_at;
    }

    /**
     * Scope a query to only include verified users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVerified($query)
    {
        return $query->whereNotNull('verified_at');
    }
}
