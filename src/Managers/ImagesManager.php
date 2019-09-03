<?php

namespace Marktstand\Managers;

use Marktstand\Support\Image;

class ImagesManager extends Manager
{
    /**
     * Create a new image.
     *
     * @param array $data
     * @param mixed $owner
     * @param Marktstand\Support\Image|null $image
     * @return Marktstand\Support\Image
     */
    public function create($data, $owner = null, $image = null)
    {
        $image = $image ?: new Image;

        if ($owner) {
            $this->attachImage($image, $owner);
        }

        $this->makeFillable($image)->fill($data)->save();

        return $image;
    }

    /**
     * Attach an image to the given owner.
     *
     * @param mixed $owner
     * @param Marktstand\Support\Image $image
     * @return Marktstand\Support\Image
     */
    public function attach($owner, $image)
    {
        $this->makeFillable($image)->fill([
            'imageable_id' => $owner->id,
            'imageable_type' => $owner_type,
        ])->save();

        return $image;
    }

    /**
     * Set the fillable fields.
     *
     * @return array
     */
    protected function fillable()
    {
        return [
            'name', 'bucket', 'imageable_id', 'imageable_type',
        ];
    }
}
