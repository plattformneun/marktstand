<?php

namespace Marktstand\Managers;

use Marktstand\Support\Image;

trait ImagesManager
{
    /**
     * Add a new image.
     *
     * @param array                         $data
     * @param mixed                         $owner
     * @param Marktstand\Support\Image|null $image
     *
     * @return Marktstand\Support\Image
     */
    public function addImage($data, $owner = null, $image = null)
    {
        $image = $image ?: new Image();

        $this->makeImageFillable($image)
            ->fill($data);

        if ($owner) {
            $this->attachImage($image, $owner);
        }

        $image->save();

        return $image;
    }

    /**
     * Attach an image to the given owner.
     *
     * @param Marktstand\Support\Image $image
     * @param mixed                    $owner
     *
     * @return Marktstand\Support\Image
     */
    public function attachImage($image, $owner)
    {
        return $this->makeImageFillable($image)->fill([
            'imageable_id'   => $owner->id,
            'imageable_type' => $owner_type,
        ]);
    }

    /**
     * Attach an image to the given owner and save.
     *
     * @param Marktstand\Support\Image $image
     * @param mixed                    $owner
     *
     * @return Marktstand\Support\Image
     */
    public function attachImageAndSave($image, $owner)
    {
        $this->attachImage($image, $owner);

        $image->save();

        return $image;
    }

    /**
     * Set fillable fields for the given image.
     *
     * @param Marktstand\Support\Image $image
     *
     * @return Marktstand\Support\Image
     */
    public function makeImageFillable(Image $image)
    {
        return $this->setFillable($image, [
            'name', 'bucket', 'imageable_id', 'imageable_type',
        ]);
    }
}
