<?php

namespace Marktstand\Product;

use Marktstand\Support\Unit;
use Marktstand\Support\Image;
use Marktstand\Users\Producer;
use Marktstand\Support\Imageable;
use Marktstand\Payment\Commission;
use Marktstand\Events\ProductSaved;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use Imageable;

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
     * Get the products price.
     *
     * @return Marktstand\Product\Price
     */
    public function price()
    {
        return new Price($this);
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
     * Get the products producer name.
     *
     * @return string
     */
    public function getProducerNameAttribute()
    {
        return $this->producer->company_name;
    }

    /**
     * Get the products total price.
     *
     * @return int
     */
    public function getTotalPriceAttribute()
    {
        return $this->getTotalPrice();
    }

    /**
     * Get the products selling unit.
     *
     * @param  string $value
     * @return Marktstand\Support\Unit
     */
    public function getUnitAttribute($value)
    {
        return new Unit($value);
    }

    /**
     * Get the products price unit.
     *
     * @param  string $value
     * @return Marktstand\Support\Unit
     */
    public function getPriceUnitAttribute($value)
    {
        return new Unit($value);
    }

    /**
     * Get the products volume unit.
     *
     * @param  string $value
     * @return Marktstand\Support\Unit
     */
    public function getVolumeUnitAttribute($value)
    {
        return new Unit($value);
    }

    /**
     * Get the shop price.
     *
     * @return int
     */
    public function getTotalPrice()
    {
        $commission = new Commission($this->price()->value());

        return $commission->total();
    }

    /**
     * Get the shop base price.
     *
     * @return int
     */
    public function getTotalBasePrice()
    {
        $commission = new Commission($this->price()->base());

        return $commission->total();
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
