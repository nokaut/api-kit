<?php

namespace Nokaut\ApiKit\ClientApi\Rest\Fetch;


use Nokaut\ApiKit\Cache\CacheInterface;
use Nokaut\ApiKit\ClientApi\Rest\Query\ShopsQuery;
use Nokaut\ApiKit\Converter\ShopsConverter;

class ShopsFetch extends Fetch
{
    /**
     * @param ShopsQuery $query
     * @param CacheInterface $cache
     */
    public function __construct(ShopsQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new ShopsConverter(), $cache);
    }
}