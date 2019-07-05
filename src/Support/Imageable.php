<?php

namespace Marktstand\Support;

trait Imageable
{
    /**
     * Get the models image.
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * Get all of the models images.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
