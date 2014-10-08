<?php

namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Producers;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Producers;

class SetIsExcluded implements CallbackInterface
{
    /**
     * @param Producers $producers
     * @param Products $products
     */
    public function __invoke(Producers $producers, Products $products)
    {
        $this->setPropertyIsExcluded($producers, $products->getMetadata()->getTotal());
    }

    /**
     * @param Producers $producers
     * @param $productsTotal
     */
    protected function setPropertyIsExcluded(Producers $producers, $productsTotal)
    {
        $nonEmptyEntities = array_filter($producers->getEntities(), function ($entity) {
            return $entity->getTotal() > 0;
        });

        if (count($nonEmptyEntities) === 0) {
            $producers->setIsExcluded(true);
            return;
        }

        if (count($nonEmptyEntities) === 1
            and current($nonEmptyEntities)->getIsFilter() === false
            and current($nonEmptyEntities)->getTotal() == $productsTotal
        ) {
            $producers->setIsExcluded(true);
            return;
        }

        $producers->setIsExcluded(false);
    }
}