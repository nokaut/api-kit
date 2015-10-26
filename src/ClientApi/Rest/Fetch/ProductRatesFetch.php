<?php

namespace Nokaut\ApiKit\ClientApi\Rest\Fetch;


use Nokaut\ApiKit\Cache\CacheInterface;
use Nokaut\ApiKit\ClientApi\Rest\Query\ProductRatesQuery;
use Nokaut\ApiKit\Converter\Product\RatingConverter;

class ProductRatesFetch extends Fetch
{
    /**
     * @param ProductRatesQuery $query
     * @param CacheInterface $cache
     */
    public function __construct(ProductRatesQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new RatingConverter(), $cache);
    }
}