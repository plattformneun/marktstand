<?php

namespace Marktstand\Managers;

use Marktstand\Users\Producer;
use Marktstand\Product\Product;

trait ProductsManager
{

    /**
     * Add a new product.
     *
     * @param Marktstand\Users\Producer $producer
     * @param array $data
     * @return Marktstand\Product\Product
     */
    public function addProduct(Producer $producer, array $data)
    {
        $product = new Product;

        $this->makeProductFillable($product)->fill(array_merge($data, [
            'producer_id' => $producer->id,
        ]))->save();

        return $product;
    }

    /**
     * Update the given product.
     *
     * @param  Marktstand\Product\Product $product
     * @param  array $data
     * @return Marktstand\Product\Product
     */
    public function updateProduct(Product $product, array $data)
    {
        $this->makeProductFillable($product)
            ->update($data);

        return $product;
    }

    /**
     * Set fillable fields for the given product.
     *
     * @param  Marktstand\Product\Product $product
     * @return Marktstand\Product\Product
     */
    public function makeProductFillable(Product $product)
    {
        return $this->setFillable($product, [
            'visibillity',
            'title',
            'description',
            'characteristic',
            'article_number',
            'image_id',
            'unit',
            'volume',
            'volume_unit',
            'price',
            'price_unit',
            'vat',
            'packaging',
            'ingredients',
            'expiration',
            'lead_time',
            'deposit',
            'producer_id',
        ]);
    }
}
