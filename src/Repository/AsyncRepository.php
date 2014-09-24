<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 17.07.2014
 * Time: 11:03
 */

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\ClientApiInterface;
use Nokaut\ApiKit\ClientApi\Rest\Async\AsyncFetch;
use Nokaut\ApiKit\ClientApi\Rest\Async\AsyncFetches;

class AsyncRepository implements AsyncRepositoryInterface
{
    /**
     * @var AsyncFetches
     */
    protected static $fetches;

    /**
     * @param ClientApiInterface $clientApi
     */
    public function __construct(ClientApiInterface $clientApi)
    {
        $this->clientApi = $clientApi;
        if (empty(self::$fetches)) {
            self::$fetches = new AsyncFetches();
        }
    }

    public function addFetch(AsyncFetch $fetch)
    {
        self::$fetches->addFetch($fetch);
    }

    /**
     * Remove all requests for send to API
     */
    public function clearAllFetches()
    {
        self::$fetches = new AsyncFetches();
    }

    /**
     * Send to api all request add by method addFetch(...)
     * @throws \InvalidArgumentException
     */
    public function fetchAllAsync()
    {
        if (empty(self::$fetches)) {
            throw new \InvalidArgumentException('Empty fetches. Use method addFetch(...) add Products/Categories AsyncFetch');
        }

        $this->fetchAsync(self::$fetches);
        $this->clearAllFetches();
    }

    /**
     * @param AsyncFetches $requests
     */
    public function fetchAsync(AsyncFetches $requests)
    {
        $responses = $this->clientApi->sendMulti($requests->getQueries());

        foreach ($responses as $index => $response) {
            if ($response) {
                $requests->getItem($index)->setResult($response);
            }
        }
    }
} 