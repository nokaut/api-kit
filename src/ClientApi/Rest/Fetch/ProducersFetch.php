<?php

namespace Nokaut\ApiKit\ClientApi\Rest\Fetch;


use Nokaut\ApiKit\Cache\CacheInterface;
use Nokaut\ApiKit\ClientApi\Rest\Query\ProducersQuery;
use Nokaut\ApiKit\Converter\ProducersConverter;

class ProducersFetch extends Fetch
{
    /**
     * @param ProducersQuery $query
     * @param CacheInterface $cache
     */
    public function __construct(ProducersQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new ProducersConverter(), $cache);
    }
}