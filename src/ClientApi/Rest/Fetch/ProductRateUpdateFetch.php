<?php

namespace Nokaut\ApiKit\ClientApi\Rest\Fetch;


use Nokaut\ApiKit\Cache\CacheInterface;
use Nokaut\ApiKit\ClientApi\Rest\Query\ProductRateQuery;
use Nokaut\ApiKit\Converter\Product\RatingCreateConverter;

class ProductRateUpdateFetch extends Fetch
{
    /**
     * @param ProductRateQuery $query
     * @param CacheInterface $cache
     */
    public function __construct(ProductRateQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new RatingCreateConverter(), $cache);
    }
}