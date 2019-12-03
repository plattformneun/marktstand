<?php

namespace Marktstand\Tests\Payment;

use Illuminate\Support\Facades\Config;
use Marktstand\Payment\Commission;
use Marktstand\Tests\TestCase;

class CommissionTest extends TestCase
{
    /** @test */
    public function it_calculates_the_commission()
    {
        Config::set('marktstand.commission', 25);

        $commission = new Commission(100);

        $this->assertEquals(25, $commission->value());
    }

    /** @test */
    public function it_calculates_the_total_price()
    {
        Config::set('marktstand.commission', 25);

        $commission = new Commission(100);

        $this->assertEquals(125, $commission->total());
    }

    /** @test */
    public function it_gets_the_factor_from_config()
    {
        Config::set('marktstand.commission', 25);

        $commission = new Commission(100);

        $this->assertEquals(0.25, $commission->factor());
    }

    /** @test */
    public function it_subtracts_the_commision_from_a_given_price()
    {
        Config::set('marktstand.commission', 25);

        $this->assertEquals(75, Commission::subtract(100));
    }
}
