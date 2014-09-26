<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 13:12
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Fetch;


use Nokaut\ApiKit\Cache\CacheInterface;
use Nokaut\ApiKit\ClientApi\Rest\Query\OffersQuery;
use Nokaut\ApiKit\Converter\OffersConverter;

class OffersFetch extends Fetch
{

    public function __construct(OffersQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new OffersConverter(), $cache);
    }

} 