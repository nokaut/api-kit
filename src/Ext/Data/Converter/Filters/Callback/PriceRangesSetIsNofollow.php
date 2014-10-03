<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PriceRanges;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\PriceRange;

class PriceRangesSetIsNofollow implements PriceRangesCallbackInterface
{
    /**
     * @param PriceRanges $priceRanges
     * @param Products $products
     */
    public function __invoke(PriceRanges $priceRanges, Products $products)
    {
        $this->setProducersIsNofollow($priceRanges, $products);
    }

    /**
     * @param PriceRanges $priceRanges
     */
    protected function setProducersIsNofollow(PriceRanges $priceRanges)
    {
        foreach ($priceRanges as $priceRange) {
            /** @var PriceRange $priceRange */
            $priceRange->setIsNofollow(true);
        }
    }
}