<?php

namespace Marktstand\Managers;

use Marktstand\Product\Category;

trait SettingsManager
{
    /**
     * Add a new product category.
     *
     * @param array $data
     * @return Marktstand\Product\Category
     */
    public function addCategory(array $data)
    {
        $category = new Category;

        $this->makeCategoryFillable($category)
            ->fill($data)
            ->save();

        return $category;
    }

    /**
     * Set fillable fields for the given category.
     *
     * @param  Marktstand\Product\Category $category
     * @return Marktstand\Product\Category
     */
    public function makeCategoryFillable(Category $category)
    {
        return $this->setFillable($category, [
            'title',
        ]);
    }
}
