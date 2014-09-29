<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 17.07.2014
 * Time: 11:03
 */

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\ClientApiInterface;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\Fetch;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\Fetches;

class AsyncRepository implements AsyncRepositoryInterface
{
    /**
     * @var Fetches
     */
    protected static $fetches;

    /**
     * @param ClientApiInterface $clientApi
     */
    public function __construct(ClientApiInterface $clientApi)
    {
        $this->clientApi = $clientApi;
        if (empty(self::$fetches)) {
            self::$fetches = new Fetches();
        }
    }

    public function addFetch(Fetch $fetch)
    {
        self::$fetches->addFetch($fetch);
    }

    /**
     * Remove all requests for send to API
     */
    public function clearAllFetches()
    {
        self::$fetches = new Fetches();
    }

    /**
     * Send to api all request add by method addFetch(...)
     * @throws \InvalidArgumentException
     */
    public function fetchAllAsync()
    {
        if (empty(self::$fetches)) {
            throw new \InvalidArgumentException('Empty fetches. Use method addFetch(...) add Products/Categories/Offers Fetch');
        }

        $this->fetchAsync(self::$fetches);
        $this->clearAllFetches();
    }

    /**
     * @param Fetches $fetches
     */
    public function fetchAsync(Fetches $fetches)
    {
        $this->clientApi->sendMulti($fetches);
    }
} 