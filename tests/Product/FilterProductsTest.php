<?php

namespace Marktstand\Tests\Product;

use Marktstand\Product\Category;
use Marktstand\Product\Filter;
use Marktstand\Product\Product;
use Marktstand\Product\Quality;
use Marktstand\Tests\TestCase;

class FilterProductsTest extends TestCase
{
    /** @test */
    public function it_filters_the_products_from_category()
    {
        $product = factory(Product::class)->create();

        $product->categories()->attach([
            factory(Category::class)->create(['title' => 'Fruits'])->id,
        ]);

        $this->assertCount(1, $this->filterProducts(['fruits'])->get());
        $this->assertCount(0, $this->filterProducts(['veggies'])->get());
    }

    /** @test */
    public function it_filters_the_products_from_quality()
    {
        $product = factory(Product::class)->create();

        $product->categories()->attach([
            factory(Category::class)->create(['title' => 'Fruits'])->id,
        ]);

        $product->qualities()->attach([
            factory(Quality::class)->create(['title' => 'Demeter'])->id,
        ]);

        $this->assertCount(1, $this->filterProducts(['fruits'])->get());
        $this->assertCount(0, $this->filterProducts(['veggies'])->get());

        $this->assertCount(1, $this->filterProducts(['fruits'], ['demeter'])->get());
        $this->assertCount(0, $this->filterProducts(['fruits'], ['bioland'])->get());
    }

    /** @test */
    public function it_filters_the_products_from_filters()
    {
        $product = factory(Product::class)->create();

        $product->categories()->attach([
            factory(Category::class)->create(['title' => 'Fruits'])->id,
        ]);

        $product->filters()->attach([
            factory(Filter::class)->create(['title' => 'Peanuts'])->id,
        ]);

        $this->assertCount(1, $this->filterProducts(['fruits'])->get());
        $this->assertCount(0, $this->filterProducts(['veggies'])->get());

        $this->assertCount(1, $this->filterProducts(['fruits'], [], ['milk'])->get());
        $this->assertCount(0, $this->filterProducts(['fruits'], [], ['peanuts'])->get());
    }

    /** @test */
    public function it_filters_the_products_in_combination()
    {
        $product = factory(Product::class)->create();

        $product->categories()->attach([
            factory(Category::class)->create(['title' => 'Fruits'])->id,
        ]);

        $product->qualities()->attach([
            factory(Quality::class)->create(['title' => 'Demeter'])->id,
        ]);

        $product->filters()->attach([
            factory(Filter::class)->create(['title' => 'Peanuts'])->id,
        ]);

        $this->assertCount(1, $this->filterProducts(['fruits'])->get());
        $this->assertCount(0, $this->filterProducts(['veggies'])->get());

        $this->assertCount(1, $this->filterProducts(['fruits'], ['demeter'])->get());
        $this->assertCount(0, $this->filterProducts(['fruits'], ['bioland'])->get());

        $this->assertCount(1, $this->filterProducts(['fruits'], ['demeter'], ['milk'])->get());
        $this->assertCount(0, $this->filterProducts(['fruits'], ['demeter'], ['peanuts'])->get());
    }

    protected function filterProducts(array $categories, array $qualities = [], array $filters = [])
    {
        return (new Product)

            // from all products that belongs to any category
            ->whereHas('categories', function ($query) use ($categories) {
                // select only which belongs to the given categories
                $query->whereIn('slug', $categories);
            })

            // if their are given qualities
            ->when(count($qualities), function ($query) use ($qualities) {
                // then - from the queried products that belongs to any quality
                $query->whereHas('qualities', function ($query) use ($qualities) {
                    // select only which belongs to the given qualities
                    $query->whereIn('slug', $qualities);
                });
            })

            // if their are any given exceptional filters
            ->when(count($filters), function ($query) use ($filters) {
                // then - from the queried products that belongs to any filter
                $query->whereHas('filters', function ($query) use ($filters) {
                    // select only which NOT belongs to the given filters
                    $query->whereNotIn('slug', $filters);
                });
            })

            // OR from all products that belongs to any category
            ->orWhereHas('categories', function ($query) use ($categories) {
                // select only which belongs to the given categories
                $query->whereIn('slug', $categories);
            })

            // if their are given qualities
            ->when(count($qualities), function ($query) use ($qualities) {
                // then - from the queried products that belongs to any quality
                $query->whereHas('qualities', function ($query) use ($qualities) {
                    // select only which belongs to the given qualities
                    $query->whereIn('slug', $qualities);
                });
            })

            // and select only which NOT belongs to filters
            ->whereDoesntHave('filters');
    }
}
