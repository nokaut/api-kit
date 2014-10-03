<?php

namespace Nokaut\ApiKit\Ext\Data\Converter;

use Nokaut\ApiKit\Collection\Products;

interface ConverterInterface
{
    /**
     * @param Products $products
     * @param array $callbacks
     * @return mixed
     */
    public function convert(Products $products, $callbacks = array());
} 