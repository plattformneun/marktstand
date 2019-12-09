<?php

namespace Marktstand\Product;

use Illuminate\Database\Eloquent\Model;
use Marktstand\Support\Slugable;

class Filter extends Model
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
     * Query the products.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
