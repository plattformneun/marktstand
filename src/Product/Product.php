<?php

namespace Marktstand\Product;

use Marktstand\Support\Image;
use Marktstand\Users\Producer;
use Marktstand\Events\ProductSaved;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'prices',
    ];

    /**
     * The registered model events.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => ProductSaved::class,
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('visible', function (Builder $builder) {
            $builder->where('visibillity', true);
        });
    }

    /**
     * Get the calculated prices.
     *
     * @return array
     */
    public function getPricesAttribute()
    {
        return [
            'item' => [
                'amount' => $this->price()->total(),
                'unit' => $this->price()->unit(),
            ],
            'base' => [
                'amount' => $this->basePrice()->total(),
                'unit' => $this->basePrice()->unit(),
            ],
        ];
    }

    /**
     * Get the products price.
     *
     * @return Marktstand\Product\Price\ProductPrice
     */
    public function price()
    {
        return new Price\ProductPrice($this);
    }

    /**
     * Get the products base price.
     *
     * @return Marktstand\Product\Price\BasePrice
     */
    public function basePrice()
    {
        return new Price\BasePrice($this);
    }

    /**
     * Get the products volume.
     *
     * @return Marktstand\Product\Volume
     */
    public function volume()
    {
        return new Volume($this);
    }

    /**
     * Query the producer of the product.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function producer()
    {
        return $this->belongsTo(Producer::class);
    }

    /**
     * Query the categories.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Query the filters.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function filters()
    {
        return $this->belongsToMany(Filter::class);
    }

    /**
     * Query the qualities.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function qualities()
    {
        return $this->morphToMany(Quality::class, 'qualifyable');
    }

    /**
     * Get the products thumbnail.
     *
     * @return Markststand\Support\Image
     */
    public function thumbnail()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
}
