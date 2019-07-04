<?php

namespace Marktstand\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Marktstand extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'marktstand';
    }
}
