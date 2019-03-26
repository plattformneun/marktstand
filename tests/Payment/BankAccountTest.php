<?php

namespace Marktstand\Tests\Payment;

use Marktstand\Payment\BankAccount;
use Marktstand\Payment\BankAccountCode;
use Marktstand\Payment\BankAccountNumber;
use Marktstand\Tests\TestCase;

class BankAccountTest extends TestCase
{
   /** @test */
   public function it_holds_the_iban()
   {
       $account = factory(BankAccount::class)->create();

       $this->assertTrue($account->number instanceof BankAccountNumber);
   }

   /** @test */
   public function it_may_holds_the_swift_code()
   {
       $account = factory(BankAccount::class)->create([
            'code' => null
       ]);
       $this->assertNull($account->code);

       $account->code = 'DABAIE2D';
       $this->assertTrue($account->code instanceof BankAccountCode);
   }
}
