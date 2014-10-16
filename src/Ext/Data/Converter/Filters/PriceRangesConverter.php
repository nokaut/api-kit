<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Entity\Metadata\Facet\PriceFacet;
use Nokaut\ApiKit\Ext\Data\Converter\ConverterInterface;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\PriceRanges\CallbackInterface;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PriceRanges;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\PriceRange;

class PriceRangesConverter implements ConverterInterface
{
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
        $facetPriceRanges = $products->getPrices();
        $priceRanges = array();

        foreach ($facetPriceRanges as $facetPriceRange) {
            $priceRange = new PriceRange();
            $priceRange->setName($this->getPriceRangeName($facetPriceRange));
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
        if ($priceRanges) {
            $priceRangesCollection->setUrlInTemplate($this->prepareUrlInTemplate(current($priceRanges)));
        }

        return $priceRangesCollection;
    }

    /**
     * @param PriceFacet $range
     * @return string
     */
    protected function getPriceRangeName(PriceFacet $range)
    {
        if ($range->getMin() == $range->getMax()) {
            return number_format($range->getMin(), 2, ',', '');
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