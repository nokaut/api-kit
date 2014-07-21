<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 13:10
 */

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\Rest\Async\OffersAsyncFetch;
use Nokaut\ApiKit\ClientApi\Rest\Query\Sort;

class OffersAsyncRepository extends OffersRepository
{

    /**
     * @param string $apiBaseUrl
     */
    public function __construct($apiBaseUrl)
    {
        $this->apiBaseUrl = $apiBaseUrl;
    }

    /**
     * @param $productId
     * @param array $fields
     * @param Sort $sort
     * @return OffersAsyncFetch
     */
    public function fetchOffersByProductId($productId, array $fields, Sort $sort = null)
    {
        return new OffersAsyncFetch($this->prepareQueryForFetchOffersByProductId($productId, $fields, $sort));
    }


}