<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Property;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PropertyAbstract;

class SetIsActive implements CallbackInterface
{
    /**
     * @param PropertyAbstract $property
     * @param Products $products
     */
    public function __invoke(PropertyAbstract $property, Products $products)
    {
        $this->setPropertyIsActive($property);
    }

    /**
     * @param PropertyAbstract $property
     */
    protected function setPropertyIsActive(PropertyAbstract $property)
    {
        $countSelectedFilters = $this->countSelectedFiltersEntities($property);
        if ($countSelectedFilters > 0 and $countSelectedFilters < $property->count()) {
            $property->setIsActive(true);
            return;
        }

        $property->setIsActive(false);
    }

    /**
     * @param PropertyAbstract $property
     * @return int
     */
    public function countSelectedFiltersEntities(PropertyAbstract $property)
    {
        return count(array_filter($property->getEntities(), function ($entity) {
            return $entity->getIsFilter();
        }));
    }
}