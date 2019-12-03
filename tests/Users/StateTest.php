<?php

namespace Marktstand\Tests\Users;

use Carbon\Carbon;
use Marktstand\Company\Company;
use Marktstand\Company\Contact;
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
            'verified_at' => Carbon::now(),
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

    /** @test */
    public function it_may_hasnt_a_bank_account()
    {
        $producer = factory(Producer::class)->create();

        $this->assertFalse($this->state($producer)->hasBankAccounts());
        $this->assertFalse($producer->state()->hasBankAccounts());
    }

    /** @test */
    public function it_may_has_a_company()
    {
        $producer = factory(Producer::class)->create();

        factory(Company::class)->create([
            'user_id' => $producer->id,
            'user_type' => 'producer',
        ]);

        $this->assertTrue($this->state($producer)->hasCompany());
        $this->assertTrue($producer->state()->hasCompany());
    }

    /** @test */
    public function it_may_hasnt_a_company()
    {
        $producer = factory(Producer::class)->create();

        $this->assertFalse($this->state($producer)->hasCompany());
        $this->assertFalse($producer->state()->hasCompany());
    }

    /** @test */
    public function it_may_has_contacts()
    {
        $producer = factory(Producer::class)->create();

        factory(Contact::class)->create([
            'user_id' => $producer->id,
            'user_type' => 'producer',
        ]);

        $this->assertTrue($this->state($producer)->hasContacts());
        $this->assertTrue($producer->state()->hasContacts());
    }

    /** @test */
    public function it_may_hasnt_contacts()
    {
        $producer = factory(Producer::class)->create();

        $this->assertFalse($this->state($producer)->hasContacts());
        $this->assertFalse($producer->state()->hasContacts());
    }

    protected function state($user)
    {
        return new State($user);
    }
}
