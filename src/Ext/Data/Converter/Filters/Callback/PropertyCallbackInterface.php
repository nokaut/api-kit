<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PropertyAbstract;

interface PropertyCallbackInterface {

    /**
     * @param PropertyAbstract $property
     * @param Products $products
     * @return
     */
    public function __invoke(PropertyAbstract $property, Products $products);
}