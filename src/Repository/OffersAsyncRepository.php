<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 13:10
 */

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\ClientApiInterface;
use Nokaut\ApiKit\ClientApi\Rest\Async\OffersAsyncFetch;
use Nokaut\ApiKit\ClientApi\Rest\Query\Sort;

class OffersAsyncRepository extends OffersRepository implements AsyncRepositoryInterface
{
    /**
     * @var AsyncRepository
     */
    protected $asyncRepo;

    /**
     * @param string $apiBaseUrl
     * @param ClientApiInterface $clientApi
     */
    public function __construct($apiBaseUrl, ClientApiInterface $clientApi)
    {
        $this->apiBaseUrl = $apiBaseUrl;
        $this->asyncRepo = AsyncRepository::getInstance($clientApi);
    }

    public function clearAllFetches()
    {
        $this->asyncRepo->clearAllFetches();
    }

    public function fetchAllAsync()
    {
        $this->asyncRepo->fetchAllAsync();
    }

    /**
     * @param $productId
     * @param array $fields
     * @param Sort $sort
     * @return OffersAsyncFetch
     */
    public function fetchOffersByProductId($productId, array $fields, Sort $sort = null)
    {
        $offersAsyncFetch = new OffersAsyncFetch($this->prepareQueryForFetchOffersByProductId($productId, $fields, $sort));
        $this->asyncRepo->addFetch($offersAsyncFetch);
        return $offersAsyncFetch;
    }
}