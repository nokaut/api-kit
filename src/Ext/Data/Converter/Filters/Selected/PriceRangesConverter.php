<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Selected;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\PriceRanges\CallbackInterface;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\PriceRangesConverter as PriceRangesConverterParent;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PriceRanges;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\PriceRange;

class PriceRangesConverter extends PriceRangesConverterParent
{
    /**
     * @param Products $products
     * @param CallbackInterface[] $callbacks
     * @return PriceRanges
     */
    public function convert(Products $products, $callbacks = array())
    {
        $priceRanges = parent::convert($products, array());

        $priceRanges->setEntities(array_filter($priceRanges->getEntities(), function ($entity) {
            /** @var PriceRange $entity */
            return $entity->getIsFilter();
        }));

        foreach ($callbacks as $callback) {
            $callback($priceRanges, $products);
        }

        return $priceRanges;
    }
}