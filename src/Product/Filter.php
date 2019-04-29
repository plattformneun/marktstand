<?php

namespace Marktstand\Product;

use Marktstand\Support\Slugable;
use Illuminate\Database\Eloquent\Model;

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
