<?php

namespace Marktstand\Tests\Users;

use Carbon\Carbon;
use Marktstand\Payment\BankAccount;
use Marktstand\Tests\TestCase;
use Marktstand\Users\Producer;
use Marktstand\Users\State;

class StateTest extends TestCase
{
    /** @test */
    public function it_may_be_verified()
    {
        $producer = factory(Producer::class)->create([
            'verified_at' => Carbon::now()
        ]);

        $this->assertTrue($this->state($producer)->isVerified());
        $this->assertTrue($producer->state()->isVerified());
    }

    /** @test */
    public function it_may_has_bank_accounts()
    {
        $producer = factory(Producer::class)->create();

        factory(BankAccount::class)->create([
            'user_id' => $producer->id,
            'user_type' => 'producer',
        ]);

        $this->assertTrue($this->state($producer)->hasBankAccounts());
        $this->assertTrue($producer->state()->hasBankAccounts());
    }

    protected function state($user)
    {
        return new State($user);
    }
}
