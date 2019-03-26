<?php

namespace Marktstand\Tests\Product;

use Marktstand\Exceptions\DuplicateSlugException;
use Marktstand\Product\Category;
use Marktstand\Product\Product;
use Marktstand\Tests\TestCase;

class CategoryTest extends TestCase
{
    /** @test */
    public function it_fetches_the_main_categories()
    {
        factory(Category::class)->create([
            'title' => 'Vegetables',
            'slug' => 'vegetables',
            'parent_id' => null
        ]);

        factory(Category::class)->create([
            'title' => 'Fruits',
            'slug' => 'fruits',
            'parent_id' => null
        ]);

        $this->assertCount(2, Category::main()->get());
    }

    /** @test */
    public function it_fetches_a_categories_subcategories()
    {
        $parent = factory(Category::class)->create([
            'title' => 'Fruits',
            'slug' => 'fruits',
        ]);

        factory(Category::class)->create([
            'title' => 'Apples',
            'slug' => 'apples',
            'parent_id' => $parent->id
        ]);

        factory(Category::class)->create([
            'title' => 'Berries',
            'slug' => 'berries',
            'parent_id' => $parent->id
        ]);

        $this->assertCount(2, $parent->childrens);
    }

    /** @test */
    public function it_fetches_the_categories_parentcategory()
    {
        $parent = factory(Category::class)->create([
            'title' => 'Fruits',
            'slug' => 'fruits',
        ]);

        $child = factory(Category::class)->create([
            'title' => 'Apples',
            'slug' => 'apples',
            'parent_id' => $parent->id
        ]);

        $this->assertEquals($parent->id, $child->parent->id);
    }

    /** @test */
    public function it_belongs_to_products()
    {
        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create();

        $category->products()->attach([$product->id]);

        $this->assertDatabaseHas('category_product', [
            'category_id' => $category->id,
            'product_id' => $product->id
        ]);

        $this->assertCount(1, $category->products);
    }

    /** @test */
    public function it_generates_a_slug()
    {
        $category = Category::forceCreate([
            'title' => 'Organic Bananas'
        ]);

        $this->assertEquals('organic-bananas', $category->slug);
    }

    /** @test */
    public function it_validates_the_slug()
    {
        $this->expectException(DuplicateSlugException::class);

        factory(Category::class)->create([
            'title' => 'Organic Bananas',
            'slug' => 'organic-bananas'
        ]);

        $category = Category::forceCreate([
            'title' => 'Organic Bananas'
        ]);
    }
}
