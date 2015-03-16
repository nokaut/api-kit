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
     * @var array
     */
    private static $cache = array();

    /**
     * @param Products $products
     * @param FiltersAbstract $skipFilter
     * @return bool
     */
    public static function filtersNofollow(Products $products, FiltersAbstract $skipFilter = null)
    {
        $cacheKey = self::getCacheKey($products, $skipFilter);
        if (!isset(self::$cache[$cacheKey])) {
            self::$cache[$cacheKey] = self::areFiltersNofollow($products, $skipFilter);
        }

        return self::$cache[$cacheKey];
    }

    private static function getCacheKey(Products $products, FiltersAbstract $skipFilter = null)
    {
        $cacheKey = $products->getMetadata() ? $products->getMetadata()->getUrl() : serialize($products->getEntities());
        $cacheKey .= get_class($skipFilter);
        $cacheKey .= ($skipFilter instanceof PropertyAbstract ? $skipFilter->getId() : '');

        return md5($cacheKey);
    }

    /**
     * @param Products $products
     * @param FiltersAbstract $skipFilter
     * @return bool
     */
    private static function areFiltersNofollow(Products $products, FiltersAbstract $skipFilter = null)
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

        $propertyFiltersGroupSet = 0;
        foreach ($products->getProperties() as $property) {
            if ($property->getRanges()) {
                if (count(array_filter($property->getRanges(), function ($range) {
                        return $range->getIsFilter();
                    })) >= 1
                ) {
                    if ($skipFilter instanceof PropertyAbstract and $property->getId() != $skipFilter->getId()) {
                        return true;
                    }
                }
            } elseif ($property->getValues()) {
                if (count(array_filter($property->getValues(), function ($range) {
                        return $range->getIsFilter();
                    })) >= 2
                ) {
                    if ($skipFilter instanceof PropertyAbstract and $property->getId() != $skipFilter->getId()) {
                        return true;
                    }
                }

                // if numeric filter is set
                if (count(array_filter($property->getValues(), function ($value) {
                        return (is_numeric($value->getName()) and $value->getIsFilter());
                    })) >= 1
                ) {
                    if ($skipFilter instanceof PropertyAbstract and $property->getId() != $skipFilter->getId()) {
                        return true;
                    }
                }

                // if filter group is set - count them
                if (count(array_filter($property->getValues(), function ($value) {
                        return $value->getIsFilter();
                    })) >= 1
                ) {
                    if ($skipFilter instanceof PropertyAbstract and $property->getId() != $skipFilter->getId()) {
                        $propertyFiltersGroupSet++;
                    }
                }
            }
        }

        if ($propertyFiltersGroupSet > 1) {
            return true;
        }

        return false;
    }

    /**
     * @param Products $products
     * @return bool
     */
    public static function productsNoindex(Products $products)
    {
        // if price filter is set
        if (count(array_filter($products->getPrices(), function ($priceRange) {
                /** @var PriceFacet $priceRange */
                return $priceRange->getIsFilter();
            })) >= 1
        ) {
            return true;
        }

        $filtersGroupSetCount = 0;

        if (count(array_filter($products->getShops(), function ($shop) {
                /** @var ShopFacet $shop */
                return $shop->getIsFilter();
            })) >= 1
        ) {
            $filtersGroupSetCount++;
        }

        if (count(array_filter($products->getProducers(), function ($producer) {
                /** @var ProducerFacet $producer */
                return $producer->getIsFilter();
            })) >= 1
        ) {
            $filtersGroupSetCount++;
        }

        foreach ($products->getProperties() as $property) {
            if ($property->getRanges()) {
                // if range filter is set
                if (count(array_filter($property->getRanges(), function ($range) {
                        return $range->getIsFilter();
                    })) >= 1
                ) {
                    return true;
                }
            } elseif ($property->getValues()) {
                // if numeric filter is set
                if (count(array_filter($property->getValues(), function ($value) {
                        return (is_numeric($value->getName()) and $value->getIsFilter());
                    })) >= 1
                ) {
                    return true;
                }

                // if filter group is set - count them
                if (count(array_filter($property->getValues(), function ($value) {
                        return $value->getIsFilter();
                    })) >= 1
                ) {
                    $filtersGroupSetCount++;
                }
            }
        }

        if ($filtersGroupSetCount > 1) {
            return true;
        }

        return false;
    }
}