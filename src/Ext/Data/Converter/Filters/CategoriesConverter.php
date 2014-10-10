<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Converter\ConverterInterface;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Categories\CallbackInterface;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Categories;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Category;

class CategoriesConverter implements ConverterInterface
{
    /**
     * @param Products $products
     * @param CallbackInterface[] $callbacks
     * @return Categories
     */
    public function convert(Products $products, $callbacks = array())
    {
        $categories = $this->initialConvert($products);

        foreach ($callbacks as $callback) {
            $callback($categories, $products);
        }

        return $categories;
    }

    /**
     * @param Products $products
     * @return Categories
     */
    public function initialConvert(Products $products)
    {
        $facetCategories = $products->getCategories();
        $categories = array();

        foreach ($facetCategories as $facetCategory) {
            $category = new Category();
            $category->setId($facetCategory->getId());
            $category->setName($facetCategory->getName());
            $category->setUrl($facetCategory->getUrl());
            $category->setUrlBase($facetCategory->getUrlBase());
            $category->setUrlIn($facetCategory->getUrlIn());
            $category->setUrlOut($facetCategory->getUrlOut());
            $category->setIsFilter($facetCategory->getIsFilter());
            $category->setTotal((int)$facetCategory->getTotal());

            $categories[] = $category;
        }

        $categoryCollection = new Categories($categories);
        $categoryCollection->setName("Kategoria");

        return $categoryCollection;
    }
}