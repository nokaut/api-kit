<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 23.09.2014
 * Time: 15:11
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Async;


use Nokaut\ApiKit\ClientApi\Rest\Query\OfferQuery;
use Nokaut\ApiKit\Converter\OfferConverter;

class OfferAsyncFetch extends AsyncFetch
{

    public function __construct(OfferQuery $query)
    {
        $this->query = $query;
        $this->converter = new OfferConverter();
    }

} 