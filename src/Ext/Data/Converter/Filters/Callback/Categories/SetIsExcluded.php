<?php

namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Categories;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Categories;

class SetIsExcluded implements CallbackInterface
{
    /**
     * @param Categories $categories
     * @param Products $products
     */
    public function __invoke(Categories $categories, Products $products)
    {
        $this->setIsExcluded($categories, $products->getMetadata()->getTotal());
    }

    /**
     * @param Categories $categories
     * @param $productsTotal
     */
    protected function setIsExcluded(Categories $categories, $productsTotal)
    {
        $nonEmptyEntities = array_filter($categories->getEntities(), function ($entity) {
            return $entity->getTotal() > 0;
        });

        if (count($nonEmptyEntities) === 0) {
            $categories->setIsExcluded(true);
            return;
        }

        if (count($nonEmptyEntities) === 1
            and current($nonEmptyEntities)->getTotal() == $productsTotal
        ) {
            $categories->setIsExcluded(true);
            return;
        }

        $categories->setIsExcluded(false);
    }
}