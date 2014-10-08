<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Producers;

interface ProducersCallbackInterface
{

    /**
     * @param Producers $producers
     * @param Products $products
     * @return
     */
    public function __invoke(Producers $producers, Products $products);
}