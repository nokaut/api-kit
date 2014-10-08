<?php

namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Shops;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Shops;

class SetIsExcluded implements CallbackInterface
{
    /**
     * @param Shops $shops
     * @param Products $products
     */
    public function __invoke(Shops $shops, Products $products)
    {
        $this->setPropertyIsExcluded($shops, $products->getMetadata()->getTotal());
    }

    /**
     * @param Shops $shops
     * @param $productsTotal
     */
    protected function setPropertyIsExcluded(Shops $shops, $productsTotal)
    {
        $nonEmptyEntities = array_filter($shops->getEntities(), function ($entity) {
            return $entity->getTotal() > 0;
        });

        if (count($nonEmptyEntities) === 0) {
            $shops->setIsExcluded(true);
            return;
        }

        if (count($nonEmptyEntities) === 1
            and current($nonEmptyEntities)->getIsFilter() === false
            and current($nonEmptyEntities)->getTotal() == $productsTotal
        ) {
            $shops->setIsExcluded(true);
            return;
        }

        $shops->setIsExcluded(false);
    }
}