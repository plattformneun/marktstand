<?php

namespace Marktstand\Tests\Payment;

use Marktstand\Exceptions\InvalidArgumentException;
use Marktstand\Payment\BankAccountNumber;
use Marktstand\Tests\TestCase;

class BankAccountNumberTest extends TestCase
{
    /** @test */
    public function it_gets_the_iban()
    {
        $number = new BankAccountNumber('de0450 01051 7884564 3911');

        $this->assertEquals('DE04500105178845643911', $number->iban());
    }

    /** @test */
    public function it_gets_the_last_four_digits()
    {
        $number = new BankAccountNumber('DE04500105178845643911');

        $this->assertEquals('3911', $number->lastFour());
    }

    /** @test */
    public function it_converts_to_a_string()
    {
        $number = new BankAccountNumber('DE04500105178845643911');

        $this->assertEquals('DE04500105178845643911', (string) $number);
    }

    /** @test */
    public function it_validates_the_country_code()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Country Code');

        new BankAccountNumber('XX 0450 0105 1788 4564 3911');
    }

    /** @test */
    public function it_validates_the_allowed_characters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Characters');

        new BankAccountNumber('DE 0450 0105 -788 4564 !911');
    }

    /** @test */
    public function it_validates_the_format()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Format');

        new BankAccountNumber('DE 0450 0105 1788 4564');
    }
}
