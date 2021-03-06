<?php

namespace Marktstand\Product;

use Illuminate\Database\Eloquent\Model;
use Marktstand\Support\Slugable;
use Marktstand\Users\Producer;

class Quality extends Model
{
    use Slugable;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->generateSlug($model->title);
        });
    }

    /**
     * Get all of the products that are assigned this quality.
     */
    public function products()
    {
        return $this->morphedByMany(Product::class, 'qualifyable');
    }

    /**
     * Get all of the producers that are assigned this quality.
     */
    public function producers()
    {
        return $this->morphedByMany(Producer::class, 'qualifyable');
    }
}
