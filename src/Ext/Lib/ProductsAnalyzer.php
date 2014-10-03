<?php


namespace Nokaut\ApiKit\Ext\Lib;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Entity\Metadata\Facet\PriceFacet;
use Nokaut\ApiKit\Entity\Metadata\Facet\ProducerFacet;
use Nokaut\ApiKit\Entity\Metadata\Facet\ShopFacet;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\FiltersAbstract;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PriceRanges;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Producers;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PropertyAbstract;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Shops;

class ProductsAnalyzer
{
    /**
     * @param Products $products
     * @param FiltersAbstract $skipFilter
     * @return bool
     */
    public static function filtersNofollow(Products $products, FiltersAbstract $skipFilter = null)
    {
        if (!($skipFilter instanceof Shops) and count(array_filter($products->getShops(), function ($shop) {
                /** @var ShopFacet $shop */
                return $shop->getIsFilter();
            })) >= 2
        ) {
            return true;
        }

        if (!($skipFilter instanceof Producers) and count(array_filter($products->getProducers(), function ($producer) {
                /** @var ProducerFacet $producer */
                return $producer->getIsFilter();
            })) >= 2
        ) {
            return true;
        }

        if (!($skipFilter instanceof PriceRanges) and count(array_filter($products->getPrices(), function ($priceRange) {
                /** @var PriceFacet $priceRange */
                return $priceRange->getIsFilter();
            })) >= 1
        ) {
            return true;
        }

        foreach ($products->getProperties() as $property) {
            if ($property->getRanges()) {
                if (count(array_filter($property->getRanges(), function ($range) {
                        return $range->getIsFilter();
                    })) >= 1
                ) {
                    if ($skipFilter instanceof PropertyAbstract and $property->getId() != $skipFilter->getId()) {
                        return true;
                    } else {
                        return false;
                    }
                }
            } elseif ($property->getValues()) {
                if (count(array_filter($property->getValues(), function ($range) {
                        return $range->getIsFilter();
                    })) >= 2
                ) {
                    if ($skipFilter instanceof PropertyAbstract and $property->getId() != $skipFilter->getId()) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }

        return false;
    }

    /**
     * @param Products $products
     * @return bool
     */
    public static function productsNoindex(Products $products)
    {
        if ($products->getMetadata()->getCanonical() != $products->getMetadata()->getUrl()) {
            return true;
        } else {
            return false;
        }
    }
}