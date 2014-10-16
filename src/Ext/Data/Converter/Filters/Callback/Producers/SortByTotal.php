<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Producers;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Producers;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Sort;

class SortByTotal implements CallbackInterface
{
    /**
     * @param Producers $producers
     * @param Products $products
     */
    public function __invoke(Producers $producers, Products $products)
    {
        Sort\SortByTotal::sort($producers);
    }
}