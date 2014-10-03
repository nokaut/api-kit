<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\FiltersAbstract;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PropertyAbstract;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\FilterAbstract;

class PropertySetIsActive implements PropertyCallbackInterface
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
        if ($this->countSelectedFiltersEntities($property) and $this->countSelectedFiltersEntities($property) < $property->count()) {
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
        return count($this->getSelectedFilterEntities($property));
    }

    /**
     * @param FiltersAbstract $property
     * @return FilterAbstract[]
     */
    protected function getSelectedFilterEntities(FiltersAbstract $property)
    {
        return array_filter($property->getEntities(), function ($entity) {
            return $entity->getIsFilter();
        });
    }
}