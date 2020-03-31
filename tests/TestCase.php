<?php

namespace Marktstand\Tests;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/../database/factories');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Load package service provider.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return lasselehtinen\MyPackage\MyPackageServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [\Marktstand\ServiceProvider::class];
    }
}
