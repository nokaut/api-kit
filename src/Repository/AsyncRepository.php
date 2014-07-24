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
     * @var $this
     */
    private static $instance;
    /**
     * @var AsyncFetches
     */
    protected $fetches;

    public static function getInstance(ClientApiInterface $clientApi)
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($clientApi);
        }
        return self::$instance;
    }
    /**
     * @param ClientApiInterface $clientApi
     */
    private function __construct(ClientApiInterface $clientApi)
    {
        $this->clientApi = $clientApi;
        $this->fetches = new AsyncFetches();
    }

    public function addFetch(AsyncFetch $fetch)
    {
        $this->fetches->addFetch($fetch);
    }

    /**
     * Remove all requests for send to API
     */
    public function clearAllFetches()
    {
        $this->fetches = new AsyncFetches();
    }

    /**
     * Send to api all request add by method addFetch(...)
     * @throws \InvalidArgumentException
     */
    public function fetchAllAsync()
    {
        if (empty($this->fetches)) {
            throw new \InvalidArgumentException('Empty fetches. Use method addFetch(...) add Products/Categories AsyncFetch');
        }

        $this->fetchAsync($this->fetches);
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