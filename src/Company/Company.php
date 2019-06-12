<?php

namespace Marktstand\Company;

use Marktstand\Support\Slug;
use Marktstand\Support\Image;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * Get the company owner.
     */
    public function user()
    {
        return $this->morphTo();
    }

    /**
     * Get the profile image.
     */
    public function profileImage()
    {
        return $this->belongsTo(Image::class, 'profile_image');
    }

    /**
     * Get the title image.
     */
    public function titleImage()
    {
        return $this->belongsTo(Image::class, 'title_image');
    }
}
