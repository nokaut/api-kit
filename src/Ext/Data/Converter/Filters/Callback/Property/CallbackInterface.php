<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Property;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PropertyAbstract;

interface CallbackInterface
{

    /**
     * @param PropertyAbstract $property
     * @param Products $products
     * @return
     */
    public function __invoke(PropertyAbstract $property, Products $products);
}