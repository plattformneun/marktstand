<?php

namespace Marktstand\Product;

use Marktstand\Support\Slugable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
     * Query the main categories.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public static function main()
    {
        return self::whereNull('parent_id');
    }

    /**
     * Query the main subcategories.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function childrens()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Query the parent category.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
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
