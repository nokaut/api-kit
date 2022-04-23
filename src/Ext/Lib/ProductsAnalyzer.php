<?php


namespace Nokaut\ApiKit\Ext\Lib;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Entity\Metadata\Facet\PriceFacet;
use Nokaut\ApiKit\Entity\Metadata\Facet\ProducerFacet;
use Nokaut\ApiKit\Entity\Metadata\Facet\PropertyFacet;
use Nokaut\ApiKit\Entity\Metadata\Facet\ShopFacet;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\FiltersAbstract;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PriceRanges;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Producers;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PropertyAbstract;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Shops;

class ProductsAnalyzer
{
    const NOFOLLOW_SHOP_FILTER_SET_COUNT_MAX = 2;
    const NOFOLLOW_PRODUCER_FILTER_SET_COUNT_MAX = 2;
    const NOFOLLOW_PRICE_RANGE_FILTER_SET_COUNT_MAX = 1;
    const NOFOLLOW_PROPERTY_FILTER_RANGE_SET_COUNT_MAX = 1;
    const NOFOLLOW_PROPERTY_FILTER_VALUE_SET_COUNT_MAX = 2;
    const NOFOLLOW_PROPERTY_FILTER_VALUE_NUMERIC_SET_COUNT_MAX = 1;
    const NOFOLLOW_GROUPS_FILTER_SET_COUNT_MAX = 2;
    const NOINDEX_GROUPS_FILTER_SET_COUNT_MAX = 2;

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

    private static function getCacheKey(Products $products, FiltersAbstract $skipFilter = null, $additionalKey = null)
    {
        $cacheKey = $products->getMetadata() ? $products->getMetadata()->getUrl() : serialize($products->getEntities());

        if ($skipFilter) {
            $cacheKey .= get_class($skipFilter);
            $cacheKey .= ($skipFilter instanceof PropertyAbstract ? $skipFilter->getId() : '');
        }

        if ($additionalKey) {
            $cacheKey .= $additionalKey;
        }

        return md5((string)$cacheKey);
    }

    private static function countShopFilterSet(Products $products)
    {
        $cacheKey = self::getCacheKey($products, null, __METHOD__);

        if (!isset(self::$cache[$cacheKey])) {
            self::$cache[$cacheKey] = count(array_filter($products->getShops(), function ($shop) {
                /** @var ShopFacet $shop */
                return $shop->getIsFilter();
            }));

        }

        return self::$cache[$cacheKey];
    }

    private static function countProducerFilterSet(Products $products)
    {
        $cacheKey = self::getCacheKey($products, null, __METHOD__);

        if (!isset(self::$cache[$cacheKey])) {
            self::$cache[$cacheKey] = count(array_filter($products->getProducers(), function ($producer) {
                /** @var ProducerFacet $producer */
                return $producer->getIsFilter();
            }));

        }

        return self::$cache[$cacheKey];
    }

    private static function countPriceRangeFilterSet(Products $products)
    {
        $cacheKey = self::getCacheKey($products, null, __METHOD__);

        if (!isset(self::$cache[$cacheKey])) {
            self::$cache[$cacheKey] = count(array_filter($products->getPrices(), function ($priceRange) {
                /** @var PriceFacet $priceRange */
                return $priceRange->getIsFilter();
            }));
        }

        return self::$cache[$cacheKey];
    }

    private static function countPropertyFilterSet(Products $products, PropertyFacet $property)
    {
        $cacheKey = self::getCacheKey($products, null, __METHOD__ . $property->getId());

        if (!isset(self::$cache[$cacheKey])) {

            if ($property->getRanges()) {
                self::$cache[$cacheKey] = count(array_filter($property->getRanges(), function ($range) {
                    return $range->getIsFilter();
                }));
            } elseif ($property->getValues()) {
                self::$cache[$cacheKey] = count(array_filter($property->getValues(), function ($value) {
                    return $value->getIsFilter();
                }));
            }
        }

        return self::$cache[$cacheKey];
    }

    public static function countGroupsWithFilterSet(Products $products, FiltersAbstract $skipFilter = null)
    {
        $groupsWithFiltersCount = 0;
        $groupsWithFiltersCount += (!($skipFilter instanceof Shops) and self::countShopFilterSet($products)) ? 1 : 0;
        $groupsWithFiltersCount += (!($skipFilter instanceof Producers) and self::countProducerFilterSet($products)) ? 1 : 0;
        $groupsWithFiltersCount += (!($skipFilter instanceof PriceRanges) and self::countPriceRangeFilterSet($products)) ? 1 : 0;

        foreach ($products->getProperties() as $property) {
            if (($skipFilter instanceof PropertyAbstract)) {
                if ($property->getId() != $skipFilter->getId()) {
                    $groupsWithFiltersCount += self::countPropertyFilterSet($products, $property) ? 1 : 0;
                }
            } else {
                $groupsWithFiltersCount += self::countPropertyFilterSet($products, $property) ? 1 : 0;
            }
        }

        return $groupsWithFiltersCount;
    }

    /**
     * @param Products $products
     * @param FiltersAbstract $skipFilter
     * @return bool
     */
    private static function areFiltersNofollow(Products $products, FiltersAbstract $skipFilter = null)
    {
        // shops
        if (!($skipFilter instanceof Shops) and self::countShopFilterSet($products) >= self::NOFOLLOW_SHOP_FILTER_SET_COUNT_MAX) {
            return true;
        }

        // producers
        if (!($skipFilter instanceof Producers) and self::countProducerFilterSet($products) >= self::NOFOLLOW_PRODUCER_FILTER_SET_COUNT_MAX) {
            return true;
        }

        // price ranges
        if (!($skipFilter instanceof PriceRanges) and self::countPriceRangeFilterSet($products) >= self::NOFOLLOW_PRICE_RANGE_FILTER_SET_COUNT_MAX) {
            return true;
        }

        // properties
        foreach ($products->getProperties() as $property) {
            if ($property->getRanges()) {
                if (self::countPropertyFilterSet($products, $property) >= self::NOFOLLOW_PROPERTY_FILTER_RANGE_SET_COUNT_MAX) {
                    if ($skipFilter instanceof PropertyAbstract and $property->getId() != $skipFilter->getId()) {
                        return true;
                    }
                }
            } elseif ($property->getValues()) {
                if (self::countPropertyFilterSet($products, $property) >= self::NOFOLLOW_PROPERTY_FILTER_VALUE_SET_COUNT_MAX) {
                    if ($skipFilter instanceof PropertyAbstract and $property->getId() != $skipFilter->getId()) {
                        return true;
                    }
                }

                // if numeric filter is set
                if (count(array_filter($property->getValues(), function ($value) {
                        return (is_numeric($value->getName()) and $value->getIsFilter());
                    })) >= self::NOFOLLOW_PROPERTY_FILTER_VALUE_NUMERIC_SET_COUNT_MAX
                ) {
                    if ($skipFilter instanceof PropertyAbstract and $property->getId() != $skipFilter->getId()) {
                        return true;
                    }
                }
            }
        }

        if (self::countGroupsWithFilterSet($products, $skipFilter) >= self::NOFOLLOW_GROUPS_FILTER_SET_COUNT_MAX) {
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
        if (self::countPriceRangeFilterSet($products) >= self::NOFOLLOW_PRICE_RANGE_FILTER_SET_COUNT_MAX) {
            return true;
        }

        if (self::countGroupsWithFilterSet($products) >= self::NOFOLLOW_GROUPS_FILTER_SET_COUNT_MAX) {
            return true;
        }

        foreach ($products->getProperties() as $property) {
            if ($property->getRanges()) {
                if (self::countPropertyFilterSet($products, $property) >= self::NOFOLLOW_PROPERTY_FILTER_RANGE_SET_COUNT_MAX) {
                    return true;
                }
            } elseif ($property->getValues()) {
                // if numeric filter is set
                if (count(array_filter($property->getValues(), function ($value) {
                        return (is_numeric($value->getName()) and $value->getIsFilter());
                    })) >= self::NOFOLLOW_PROPERTY_FILTER_VALUE_NUMERIC_SET_COUNT_MAX
                ) {
                    return true;
                }
            }
        }

        return false;
    }
}