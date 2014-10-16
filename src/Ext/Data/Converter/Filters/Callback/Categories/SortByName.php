<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Categories;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Categories;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Sort;

class SortByName implements CallbackInterface
{
    /**
     * @param Categories $categories
     * @param Products $products
     */
    public function __invoke(Categories $categories, Products $products)
    {
        Sort\SortByName::sort($categories);
    }
}