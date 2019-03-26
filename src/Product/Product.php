<?php

namespace Marktstand\Product;

use Illuminate\Database\Eloquent\Model;
use Marktstand\Payment\Commission;
use Marktstand\Support\Unit;
use Marktstand\Users\Producer;

class Product extends Model
{
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
        return $this->belongsToMany(Quality::class);
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
     * @return integer
     */
    public function getTotalPrice()
    {
        $commission = new Commission($this->price()->value());
        return $commission->total();
    }

    /**
     * Get the shop base price.
     * 
     * @return integer
     */
    public function getTotalBasePrice()
    {
        $commission = new Commission($this->price()->base());
        return $commission->total();
    }
}
