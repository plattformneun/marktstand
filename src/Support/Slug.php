<?php

namespace Marktstand\Support;

use Illuminate\Support\Str;

class Slug
{
    /**
     * @var string
     */
    protected $title;

    /**
     * Create a new slug instance.
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * The string presentation of the object.
     * 
     * @return string
     */
    public function __toString()
    {
        return (string) Str::slug($this->title);
    }
}
