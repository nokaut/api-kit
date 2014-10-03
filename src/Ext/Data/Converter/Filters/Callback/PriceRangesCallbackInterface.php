<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PriceRanges;

interface PriceRangesCallbackInterface {

    /**
     * @param PriceRanges $priceRanges
     * @param Products $products
     * @return
     */
    public function __invoke(PriceRanges $priceRanges, Products $products);
}