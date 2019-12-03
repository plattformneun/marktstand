<?php

namespace Marktstand\Tests\Users;

use Illuminate\Support\Facades\Event;
use Marktstand\Checkout\Cart\Cart;
use Marktstand\Company\Company;
use Marktstand\Events\UserVerified;
use Marktstand\Events\VerificationRequest;
use Marktstand\Payment\BankAccount;
use Marktstand\Tests\TestCase;
use Marktstand\Users\Customer;

class CustomerTest extends TestCase
{
    /** @test */
    public function it_may_has_many_bank_accounts()
    {
        $customer = factory(Customer::class)->create();
        factory(BankAccount::class)->create([
            'user_id' => $customer->id,
            'user_type' => 'customer',
        ]);

        factory(BankAccount::class)->create([
            'user_id' => $customer->id,
            'user_type' => 'customer',
        ]);

        $this->assertCount(2, $customer->bankAccounts);
    }

    /** @test */
    public function it_may_has_a_company()
    {
        $customer = factory(Customer::class)->create();

        $company = factory(Company::class)->create([
            'user_id' => $customer->id,
            'user_type' => 'customer',
        ]);

        $this->assertEquals($company->fresh(), $customer->company);
    }

    /** @test */
    public function it_may_creates_a_cart()
    {
        $customer = factory(Customer::class)->create();
        $customer->cart()->create();

        $this->assertTrue($customer->cart instanceof Cart);
    }

    /** @test */
    public function it_can_be_verified()
    {
        Event::fake();

        $customer = factory(Customer::class)->create([
            'verified_at' => null,
        ]);

        $this->assertFalse($customer->isVerified());

        $customer->verify();

        $this->assertTrue($customer->isVerified());
        Event::assertDispatched(UserVerified::class);
    }

    /** @test */
    public function it_may_requests_verification()
    {
        Event::fake();

        $customer = factory(Customer::class)->create();
        $customer->requestVerification();

        Event::assertDispatched(VerificationRequest::class);
    }
}
