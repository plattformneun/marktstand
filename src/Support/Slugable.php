<?php

namespace Marktstand\Support;

use Marktstand\Exceptions\DuplicateSlugException;

trait Slugable
{
    /**
     * Generate the slug.
     *
     * @param  string $value
     * @return void
     */
    public function generateSlug($value)
    {
        $slug = (string) new Slug($value);

        if ($this->slugExists($slug)) {
            throw new DuplicateSlugException(sprintf('Model with a slug "%s" already exists', $slug));
        }

        $this->slug = $slug;
    }

    /**
     * Get the models from an array of slugs.
     *
     * @param  array  $slugs
     * @return Illuminate\Support\Collection
     */
    public static function allFromSlugs(array $slugs)
    {
        return static::whereIn('slug', $slugs)->get();
    }

    /**
     * Get all models except the given array of slugs.
     *
     * @param  array  $slugs
     * @return Illuminate\Support\Collection
     */
    public static function exceptFromSlugs(array $slugs)
    {
        return static::whereNotIn('slug', $slugs)->get();
    }

    /**
     * Check if the slug already exists.
     *
     * @param  string $slug
     * @return bool
     */
    public static function slugExists(string $slug)
    {
        return static::where('slug', $slug)->exists();
    }
}
