<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Shops;
use Nokaut\ApiKit\Ext\Data\Converter\ConverterInterface;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Shops\CallbackInterface;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Shop;

class ShopsConverter implements ConverterInterface
{
    /**
     * @var array
     */
    private static $cache = array();

    /**
     * @param Products $products
     * @param CallbackInterface[] $callbacks
     * @return Shops
     */
    public function convert(Products $products, $callbacks = array())
    {
        $shops = $this->initialConvert($products);

        foreach ($callbacks as $callback) {
            $callback($shops, $products);
        }

        return $shops;
    }

    /**
     * @param Products $products
     * @return Shops
     */
    public function initialConvert(Products $products)
    {
        $cacheKey = md5($products->getMetadata()->getUrl());

        if (!isset(self::$cache[$cacheKey])) {
            $facetShops = $products->getShops();
            $shops = array();

            foreach ($facetShops as $facetShop) {
                $shop = new Shop();
                $shop->setId($facetShop->getId());
                $shop->setName($facetShop->getName());
                $shop->setParam($facetShop->getParam());
                $shop->setUrl($facetShop->getUrl());
                $shop->setUrlBase($facetShop->getUrlBase());
                $shop->setIsFilter($facetShop->getIsFilter());
                $shop->setTotal((int)$facetShop->getTotal());

                $shops[] = $shop;
            }

            $shopsCollection = new Shops($shops);
            $shopsCollection->setName('Sklep');

            if ($products->getMetadata()->getShops()) {
                $shopsCollection->setUrlOut($products->getMetadata()->getShops()->getUrlOut());
                $shopsCollection->setUrlInTemplate($products->getMetadata()->getShops()->getUrlInTemplate());
            }

            self::$cache[$cacheKey] = $shopsCollection;
        }

        return clone self::$cache[$cacheKey];
    }
}