<?php

namespace Marktstand\Support;

use ReflectionClass;

trait Reflectable
{
    /**
     * Get a reflector of the current class.
     *
     * @return ReflectionClass
     */
    public function reflector()
    {
        return new ReflectionClass($this);
    }
}
