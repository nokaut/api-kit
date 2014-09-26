<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 23.09.2014
 * Time: 15:11
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Fetch;


use Nokaut\ApiKit\Cache\CacheInterface;
use Nokaut\ApiKit\ClientApi\Rest\Query\OfferQuery;
use Nokaut\ApiKit\Converter\OfferConverter;

class OfferFetch extends Fetch
{

    public function __construct(OfferQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new OfferConverter(), $cache);
    }

} 