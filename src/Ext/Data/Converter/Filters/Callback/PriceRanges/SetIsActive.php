<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\PriceRanges;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PriceRanges;

class SetIsActive implements CallbackInterface
{
    /**
     * @param PriceRanges $priceRanges
     * @param Products $products
     */
    public function __invoke(PriceRanges $priceRanges, Products $products)
    {
        $this->setPriceRangesIsActive($priceRanges);
    }

    /**
     * @param PriceRanges $priceRanges
     */
    protected function setPriceRangesIsActive(PriceRanges $priceRanges)
    {
        $countSelectedFilters = $this->countSelectedFiltersEntities($priceRanges);
        if ($countSelectedFilters > 0 and $countSelectedFilters < $priceRanges->count()) {
            $priceRanges->setIsActive(true);
            return;
        }

        $priceRanges->setIsActive(false);
    }

    /**
     * @param PriceRanges $priceRanges
     * @return int
     */
    public function countSelectedFiltersEntities(PriceRanges $priceRanges)
    {
        return count(array_filter($priceRanges->getEntities(), function ($entity) {
            return $entity->getIsFilter();
        }));
    }
}