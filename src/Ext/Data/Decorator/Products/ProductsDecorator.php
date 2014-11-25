<?php


namespace Nokaut\ApiKit\Ext\Data\Decorator\Products;


use Nokaut\ApiKit\Collection\Products;

class ProductsDecorator
{
    public function decorate(Products $products, $callbacks = array())
    {
        foreach ($callbacks as $callback) {
            $callback($products);
        }
    }
}