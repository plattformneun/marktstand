<?php

namespace Marktstand\Support;

use Illuminate\Support\Facades\Config;

class Unit
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * Create a new unit instance.
     */
    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function type()
    {
        return $this->type;
    }

    public function base()
    {
        return $this->config('base');
    }

    public function factor()
    {
        return $this->config('factor');
    }

    /**
     * Get the units config and store it on the object.
     *
     * @return mixed
     */
    protected function config(string $key)
    {
        if(! $this->config) {
            $this->config = Config::get('marktstand.units.' . $this->type);
        }
        return $this->config[$key];
    }
}
