<?php

namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Property;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PropertyAbstract;

class SetIsExcluded implements CallbackInterface
{
    /**
     * @param PropertyAbstract $property
     * @param Products $products
     */
    public function __invoke(PropertyAbstract $property, Products $products)
    {
        $this->setPropertyIsExcluded($property, $products->getMetadata()->getTotal());
    }

    /**
     * @param PropertyAbstract $property
     * @param $productsTotal
     */
    protected function setPropertyIsExcluded(PropertyAbstract $property, $productsTotal)
    {
        $nonEmptyEntities = array_filter($property->getEntities(), function ($entity) {
            return $entity->getTotal() > 0;
        });

        if (count($nonEmptyEntities) === 0) {
            $property->setIsExcluded(true);
            return;
        }

        if (count($nonEmptyEntities) === 1
            and current($nonEmptyEntities)->getIsFilter() === false
            and current($nonEmptyEntities)->getTotal() == $productsTotal
        ) {
            $property->setIsExcluded(true);
            return;
        }

        $property->setIsExcluded(false);
    }
}