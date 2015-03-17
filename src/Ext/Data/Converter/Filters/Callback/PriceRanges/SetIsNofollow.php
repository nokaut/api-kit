<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\PriceRanges;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PriceRanges;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\PriceRange;
use Nokaut\ApiKit\Ext\Lib\ProductsAnalyzer;

class SetIsNofollow implements CallbackInterface
{
    /**
     * @param PriceRanges $priceRanges
     * @param Products $products
     */
    public function __invoke(PriceRanges $priceRanges, Products $products)
    {
        $this->setPriceRangesNofollow($priceRanges, $products);
    }

    /**
     * @param PriceRanges $priceRanges
     */
    protected function setPriceRangesNofollow(PriceRanges $priceRanges, Products $products)
    {
        $countOtherGroupsWithFilterSet = ProductsAnalyzer::countGroupsWithFilterSet($products, $priceRanges);

        foreach ($priceRanges as $priceRange) {
            /** @var PriceRange $priceRange */
            if ($priceRange->getIsFilter() and $countOtherGroupsWithFilterSet == 0) {
                $priceRange->setIsNofollow(false);
            } else {
                $priceRange->setIsNofollow(true);
            }
        }
    }
}