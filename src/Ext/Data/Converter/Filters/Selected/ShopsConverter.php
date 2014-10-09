<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Selected;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Shops\CallbackInterface;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\ShopsConverter as ShopsConverterParent;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Shops;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Shop;

class ShopsConverter extends ShopsConverterParent
{
    /**
     * @param Products $products
     * @param CallbackInterface[] $callbacks
     * @return Shops
     */
    public function convert(Products $products, $callbacks = array())
    {
        $shops = parent::convert($products, array());

        $shops->setEntities(array_filter($shops->getEntities(), function ($entity) {
            /** @var Shop $entity */
            return $entity->getIsFilter();
        }));

        foreach ($callbacks as $callback) {
            $callback($shops, $products);
        }

        return $shops;
    }
}