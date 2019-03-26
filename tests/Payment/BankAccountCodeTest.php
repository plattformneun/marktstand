<?php

namespace Marktstand\Tests\Payment;

use Marktstand\Exceptions\InvalidArgumentException;
use Marktstand\Payment\BankAccountCode;
use Marktstand\Tests\TestCase;

class BankAccountCodeTest extends TestCase
{
    /** @test */
    public function it_gets_the_swift_code()
    {
        $number = new BankAccountCode('DABAIE2D');

        $this->assertEquals('DABAIE2D', $number->swift());
    }

    /** @test */
    public function it_converts_to_a_string()
    {
        $number = new BankAccountCode('DABAIE2D');

        $this->assertEquals('DABAIE2D', (string) $number);
    }

    /** @test */
    public function it_validates_the_country_code()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Country Code');

        new BankAccountCode('DABAXX2D');
    }

    /** @test */
    public function it_validates_the_allowed_characters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Characters');

        new BankAccountCode('DABAIE-D');
    }

    /** @test */
    public function it_validates_the_format()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Format');

        new BankAccountCode('DABAIE2D123456789');
    }
}
