<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Categories;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Categories;

interface CallbackInterface
{
    /**
     * @param Categories $categories
     * @param Products $products
     * @return
     */
    public function __invoke(Categories $categories, Products $products);
}