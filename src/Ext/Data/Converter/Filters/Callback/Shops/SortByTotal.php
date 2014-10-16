<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Shops;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Shops;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Sort;

class SortByTotal implements CallbackInterface
{
    /**
     * @param Shops $shops
     * @param Products $products
     */
    public function __invoke(Shops $shops, Products $products)
    {
        Sort\SortByTotal::sort($shops);
    }
}