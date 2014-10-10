<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Converter\ConverterInterface;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Producers\CallbackInterface;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Producers;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Producer;

class ProducersConverter implements ConverterInterface
{
    /**
     * @param Products $products
     * @param CallbackInterface[] $callbacks
     * @return Producers
     */
    public function convert(Products $products, $callbacks = array())
    {
        $producers = $this->initialConvert($products);

        foreach ($callbacks as $callback) {
            $callback($producers, $products);
        }

        return $producers;
    }

    /**
     * @param Products $products
     * @return Producers
     */
    public function initialConvert(Products $products)
    {
        $facetProducers = $products->getProducers();
        $producers = array();

        foreach ($facetProducers as $facetProducer) {
            $producer = new Producer();
            $producer->setName($facetProducer->getName());
            $producer->setUrl($facetProducer->getUrl());
            $producer->setUrlBase($facetProducer->getUrlBase());
            $producer->setIsFilter($facetProducer->getIsFilter());
            $producer->setTotal((int)$facetProducer->getTotal());

            $producers[] = $producer;
        }

        $producersCollection = new Producers($producers);
        $producersCollection->setName("Producent");

        return $producersCollection;
    }
}