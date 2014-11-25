<?php


namespace Nokaut\ApiKit\Ext\Data\Decorator\Products\Callback;


use Nokaut\ApiKit\Collection\Products;

interface CallbackInterface
{
    public function __invoke(Products $products);
} 