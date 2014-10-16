<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Shops;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Shops;

class SetIsActive implements CallbackInterface
{
    /**
     * @param Shops $shops
     * @param Products $products
     */
    public function __invoke(Shops $shops, Products $products)
    {
        $this->setShopsIsActive($shops);
    }

    /**
     * @param Shops $shops
     */
    protected function setShopsIsActive(Shops $shops)
    {
        $countSelectedFilters = $this->countSelectedFiltersEntities($shops);
        if ($countSelectedFilters > 0 and $countSelectedFilters < $shops->count()) {
            $shops->setIsActive(true);
            return;
        }

        $shops->setIsActive(false);
    }

    /**
     * @param Shops $shops
     * @return int
     */
    public function countSelectedFiltersEntities(Shops $shops)
    {
        return count(array_filter($shops->getEntities(), function ($entity) {
            return $entity->getIsFilter();
        }));
    }
}