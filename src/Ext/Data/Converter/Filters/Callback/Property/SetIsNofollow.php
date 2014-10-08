<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Property;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Entity\Metadata\Facet\PriceFacet;
use Nokaut\ApiKit\Entity\Metadata\Facet\ProducerFacet;
use Nokaut\ApiKit\Entity\Metadata\Facet\ShopFacet;
use Nokaut\ApiKit\Entity\Product\Shop;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\FiltersAbstract;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PropertyAbstract;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\FilterAbstract;
use Nokaut\ApiKit\Ext\Lib\ProductsAnalyzer;

class SetIsNofollow implements CallbackInterface
{
    /**
     * @param PropertyAbstract $property
     * @param Products $products
     */
    public function __invoke(PropertyAbstract $property, Products $products)
    {
        $this->setPropertyIsNofollow($property, $products);
    }

    /**
     * @param PropertyAbstract $property
     * @param Products $products
     */
    protected function setPropertyIsNofollow(PropertyAbstract $property, Products $products)
    {
        if ($property->isPropertyRanges()) {
            /** @var FilterAbstract $value */
            foreach ($property as $value) {
                $value->setIsNofollow(true);
            }
            return;
        }

        // Jesli jakikolwiek poza biezacym property jest nofollow, to ten tez ma - nofollow
        if (ProductsAnalyzer::filtersNofollow($products, $property)) {
            /** @var FilterAbstract $value */
            foreach ($property as $value) {
                $value->setIsNofollow(true);
            }
            return;
        }

        // Jesli dany property ma zaznaczona jakas ceche
        // ale jesli jest filtrem to gdy ma zaznaczone wiecej niz dwie wartosci
        $selectedFiltersEntitiesCount = $this->countSelectedFiltersEntities($property);
        if ($selectedFiltersEntitiesCount >= 1) {
            /** @var FilterAbstract $value */
            foreach ($property as $value) {
                if ($value->getIsFilter() and $selectedFiltersEntitiesCount <= 2) {
                    $value->setIsNofollow(false);
                } else {
                    $value->setIsNofollow(true);
                }
            }
            return;
        }

        /** @var FilterAbstract $value */
        foreach ($property as $value) {
            $value->setIsNofollow(false);
        }
    }

    /**
     * @param Products $products
     * @param PropertyAbstract $skipProperty
     * @return bool
     */
    protected function isAnyFacetNofollow(Products $products, PropertyAbstract $skipProperty = null)
    {
        if (count(array_filter($products->getShops(), function ($shop) {
                /** @var ShopFacet $shop */
                return $shop->getIsFilter();
            })) >= 2
        ) {
            return true;
        }

        if (count(array_filter($products->getProducers(), function ($producer) {
                /** @var ProducerFacet $producer */
                return $producer->getIsFilter();
            })) >= 2
        ) {
            return true;
        }

        if (count(array_filter($products->getPrices(), function ($priceRange) {
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
                    if ($skipProperty and $property->getId() != $skipProperty->getId()) {
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
                    if ($skipProperty and $property->getId() != $skipProperty->getId()) {
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
     * @param PropertyAbstract $property
     * @return int
     */
    public function countSelectedFiltersEntities(PropertyAbstract $property)
    {
        return count($this->getSelectedFilterEntities($property));
    }

    /**
     * @param FiltersAbstract $property
     * @return FilterAbstract[]
     */
    protected function getSelectedFilterEntities(FiltersAbstract $property)
    {
        return array_filter($property->getEntities(), function ($entity) {
            /** @var FilterAbstract $entity */
            return $entity->getIsFilter();
        });
    }
} 