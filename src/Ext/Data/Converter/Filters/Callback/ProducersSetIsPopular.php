<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Producers;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Producer;

class ProducersSetIsPopular implements ProducersCallbackInterface
{
    /**
     * @param Producers $producers
     * @param Products $products
     */
    public function __invoke(Producers $producers, Products $products)
    {
        $this->setProducersIsPopular($producers, $products);
    }

    /**
     * @param Producers $producers
     * @param Products $products
     */
    protected function setProducersIsPopular(Producers $producers, Products $products)
    {
        /** @var Producer $producer */
        foreach ($producers as $producer) {
            if ($products->getMetadata()->getTotal() > 0
                and $producer->getTotal() / $products->getMetadata()->getTotal() > 0.1
                and $producer->getTotal() > 2
            ) {
                $producer->setIsPopular(true);
            } else {
                $producer->setIsPopular(false);
            }
        }
    }
}