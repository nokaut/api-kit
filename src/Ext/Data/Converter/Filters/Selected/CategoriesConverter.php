<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Selected;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Categories\CallbackInterface;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\CategoriesConverter as CategoriesConverterParent;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Categories;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Category;

class CategoriesConverter extends CategoriesConverterParent
{
    /**
     * @param Products $products
     * @param CallbackInterface[] $callbacks
     * @return Categories
     */
    public function convert(Products $products, $callbacks = array())
    {
        $categories = parent::convert($products, array());

        $categories->setEntities(array_filter($categories->getEntities(), function ($entity) {
            /** @var Category $entity */
            return $entity->getIsFilter();
        }));

        foreach ($callbacks as $callback) {
            $callback($categories, $products);
        }

        return $categories;
    }
}