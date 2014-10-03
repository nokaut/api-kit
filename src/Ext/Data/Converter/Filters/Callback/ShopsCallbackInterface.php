<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Shops;

interface ShopsCallbackInterface {

    /**
     * @param Shops $shops
     * @param Products $products
     * @return
     */
    public function __invoke(Shops $shops, Products $products);
}