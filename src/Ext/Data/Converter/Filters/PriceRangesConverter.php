<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Entity\Metadata\Facet\PriceFacet;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PriceRanges;
use Nokaut\ApiKit\Ext\Data\Converter\ConverterInterface;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\PriceRanges\CallbackInterface;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\PriceRange;

class PriceRangesConverter implements ConverterInterface
{
    /**
     * @var array
     */
    private static $cache = array();

    /**
     * @param Products $products
     * @param CallbackInterface[] $callbacks
     * @return PriceRanges
     */
    public function convert(Products $products, $callbacks = array())
    {
        $priceRanges = $this->initialConvert($products);

        foreach ($callbacks as $callback) {
            $callback($priceRanges, $products);
        }

        return $priceRanges;
    }

    /**
     * @param Products $products
     * @return PriceRanges
     */
    public function initialConvert(Products $products)
    {
        $cacheKey = md5($products->getMetadata()->getUrl());

        if (!isset(self::$cache[$cacheKey])) {
            $facetPriceRanges = $products->getPrices();
            $priceRanges = array();

            foreach ($facetPriceRanges as $facetPriceRange) {
                $priceRange = new PriceRange();
                $priceRange->setName($this->getPriceRangeName($facetPriceRange));
                $priceRange->setParam($facetPriceRange->getParam());
                $priceRange->setUrl($facetPriceRange->getUrl());
                $priceRange->setIsFilter($facetPriceRange->getIsFilter());
                $priceRange->setTotal((int)$facetPriceRange->getTotal());
                $priceRange->setMin($facetPriceRange->getMin());
                $priceRange->setMax($facetPriceRange->getMax());

                $priceRanges[] = $priceRange;
            }

            $priceRangesCollection = new PriceRanges($priceRanges);
            $priceRangesCollection->setName('Cena');
            $priceRangesCollection->setUnit('zł');

            if ($products->getMetadata()->getPrices()) {
                $priceRangesCollection->setUrlOut($products->getMetadata()->getPrices()->getUrlOut());
                $priceRangesCollection->setUrlInTemplate($products->getMetadata()->getPrices()->getUrlInTemplate());
            }

            /**
             * @deprecated stara wersja url in template, jesli nie korzystamy z nowej jawnie
             */
            if ($priceRanges && !$priceRangesCollection->getUrlInTemplate()) {
                $priceRangesCollection->setUrlInTemplate($this->prepareUrlInTemplate(current($priceRanges)));
            }

            self::$cache[$cacheKey] = $priceRangesCollection;
        }

        return clone self::$cache[$cacheKey];
    }

    /**
     * @param PriceFacet $range
     * @return string
     */
    protected function getPriceRangeName(PriceFacet $range)
    {
        if ($range->getMin() == $range->getMax()) {
            return number_format($range->getMin(), 2, ',', '');
        } elseif (!$range->getMin() && $range->getMax()) {
            return 'do ' . number_format($range->getMax(), 2, ',', '');
        } elseif ($range->getMin() && !$range->getMax()) {
            return 'od ' . number_format($range->getMin(), 2, ',', '');
        } else {
            return sprintf("%s - %s", number_format($range->getMin(), 2, ',', ''), number_format($range->getMax(), 2, ',', ''));
        }
    }

    /**
     * @param PriceRange $priceRange
     * @return string
     */
    protected function prepareUrlInTemplate(PriceRange $priceRange)
    {
        return preg_replace('/cena:\d+(.\d+)?~\d+(.\d+)?/', 'cena:%s~%s', $priceRange->getUrl());
    }
}