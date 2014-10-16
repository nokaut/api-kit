<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Selected;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Producers\CallbackInterface;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\ProducersConverter as ProducersConverterParent;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Producers;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Producer;

class ProducersConverter extends ProducersConverterParent
{
    /**
     * @param Products $products
     * @param CallbackInterface[] $callbacks
     * @return Producers
     */
    public function convert(Products $products, $callbacks = array())
    {
        $producers = parent::convert($products, array());

        $producers->setEntities(array_filter($producers->getEntities(), function ($entity) {
            /** @var Producer $entity */
            return $entity->getIsFilter();
        }));

        foreach ($callbacks as $callback) {
            $callback($producers, $products);
        }

        return $producers;
    }
}