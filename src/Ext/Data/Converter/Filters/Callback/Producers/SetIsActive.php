<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Producers;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Producers;

class SetIsActive implements CallbackInterface
{
    /**
     * @param Producers $producers
     * @param Products $products
     */
    public function __invoke(Producers $producers, Products $products)
    {
        $this->setProducersIsActive($producers);
    }

    /**
     * @param Producers $producers
     */
    protected function setProducersIsActive(Producers $producers)
    {
        $countSelectedFilters = $this->countSelectedFiltersEntities($producers);
        if ($countSelectedFilters > 0 and $countSelectedFilters < $producers->count()) {
            $producers->setIsActive(true);
            return;
        }

        $producers->setIsActive(false);
    }

    /**
     * @param Producers $producers
     * @return int
     */
    public function countSelectedFiltersEntities(Producers $producers)
    {
        return count(array_filter($producers->getEntities(), function ($entity) {
            return $entity->getIsFilter();
        }));
    }
}