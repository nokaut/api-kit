<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 13:12
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Async;


use Nokaut\ApiKit\ClientApi\Rest\Query\OffersQuery;
use Nokaut\ApiKit\Converter\OffersConverter;

class OffersAsyncFetch extends AsyncFetch
{

    public function __construct(OffersQuery $query)
    {
        $this->query = $query;
        $this->converter = new OffersConverter();
    }

} 