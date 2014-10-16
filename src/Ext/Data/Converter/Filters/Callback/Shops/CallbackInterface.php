<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Shops;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Shops;

interface CallbackInterface
{

    /**
     * @param Shops $shops
     * @param Products $products
     * @return
     */
    public function __invoke(Shops $shops, Products $products);
}