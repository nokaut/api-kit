<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 17.07.2014
 * Time: 11:03
 */

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\ClientApiInterface;
use Nokaut\ApiKit\ClientApi\Rest\Async\AsyncFetches;

class AsyncRepository
{

    /**
     * @param ClientApiInterface $clientApi
     */
    public function __construct(ClientApiInterface $clientApi)
    {
        $this->clientApi = $clientApi;
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