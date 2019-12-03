<?php

namespace Marktstand\Managers;

use Marktstand\Product\Product;
use Marktstand\Users\Producer;

class ProductsManager extends Manager
{
    /**
     * Eager loaded relations.
     *
     * @var array
     */
    protected $with = [];

    /**
     * Pagination count.
     *
     * @var int
     */
    protected $paginate;

    /**
     * Create a new manager instance.
     */
    public function __construct()
    {
        $this->scope = new Product;
    }

    /**
     * Remove all global scopes.
     *
     * @return self
     */
    public function withoutGlobalScopes()
    {
        $this->scope = Product::withoutGlobalScopes();

        return $this;
    }

    /**
     * The related models that should be eager loaded.
     *
     * @return self
     */
    public function with($relations)
    {
        $this->with = $relations;

        return $this;
    }

    /**
     * The related models that should be eager loaded.
     *
     * @return self
     */
    public function paginate($count)
    {
        $this->paginate = $count;

        return $this;
    }

    /**
     * Add a new product.
     *
     * @param array $data
     * @param Marktstand\Users\Producer $producer
     * @return Marktstand\Product\Product
     */
    public function create(array $data, Producer $producer)
    {
        $product = new Product;

        $this->makeFillable($product)->fill(array_merge($data, [
            'producer_id' => $producer->id,
        ]))->save();

        return $product;
    }

    /**
     * Find a product by id.
     *
     * @param  int $id
     * @param  array  $with
     * @return Marktstand\Product\Product
     */
    public function fromId($id, array $with = null)
    {
        $with = $with ?: $this->with;

        return $this->scope->with($with)->findOrFail($id);
    }

    /**
     * Get the given producers products.
     *
     * @param  Marktstand\Users\Producer $producer
     * @param  array $with
     * @return Illuminate\Support\Collection
     */
    public function fromProducer(Producer $producer, array $with = null)
    {
        $with = $with ?: $this->with;

        $query = $this->queryFromProducer($producer, $with);

        if ($this->paginate) {
            return $query->paginate($this->paginate);
        }

        return $query->get();
    }

    /**
     * Update the given product.
     *
     * @param  Marktstand\Product\Product $product
     * @param  array $data
     * @return Marktstand\Product\Product
     */
    public function update(Product $product, array $data)
    {
        $this->makeFillable($product)
            ->update($data);

        return $product;
    }

    /**
     * Query products from the given producer.
     *
     * @return Illuminate/Database/Query/Builder
     */
    protected function queryFromProducer(Producer $producer, array $with = null)
    {
        $with = $with ?: $this->with;

        return $this->scope->with($with)->where('producer_id', $producer->id);
    }

    /**
     * Define the fillable fields..
     *
     * @return array
     */
    protected function fillable()
    {
        return [
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
        ];
    }
}
