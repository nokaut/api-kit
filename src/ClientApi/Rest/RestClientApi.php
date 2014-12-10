<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 28.03.2014
 * Time: 23:04
 */

namespace Nokaut\ApiKit\ClientApi\Rest;


use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;
use Nokaut\ApiKit\ClientApi\ClientApiInterface;
use Nokaut\ApiKit\ClientApi\Rest\Exception\FatalResponseException;
use Nokaut\ApiKit\ClientApi\Rest\Exception\InvalidRequestException;
use Nokaut\ApiKit\ClientApi\Rest\Exception\NotFoundException;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\Fetch;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\Fetches;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RestClientApi implements ClientApiInterface
{
    const MAX_RETRY = 2;

    /**
     * @var \Guzzle\Http\Client
     */
    protected $client;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var \Symfony\Component\EventDispatcher\EventSubscriberInterface
     */
    protected $auth;

    public function __construct(LoggerInterface $logger, EventSubscriberInterface $auth)
    {
        $this->client = new Client();
        $this->client->addSubscriber($auth);
        $this->auth = $auth;
        $this->logger = $logger;
    }

    /**
     * @param Fetches $fetches
     */
    public function sendMulti(Fetches $fetches)
    {
        $counterRetry = 0;
        do {
            $retry = $this->sendMultiProcess($fetches);
            ++$counterRetry;

            $doRetry = $retry && $counterRetry <= self::MAX_RETRY;
            if ($doRetry) {
                $this->logger->info("retry multi send");
                usleep(100);
            }
        } while ($doRetry);
    }

    /**
     * @param Fetches $fetches
     * @return bool - need retry to get all results
     */
    protected function sendMultiProcess(Fetches $fetches)
    {
        $this->getCacheResults($fetches);

        $fetchesForFilled = $requests = array();
        foreach ($fetches as $fetch) {
            /** @var Fetch $fetch */
            if ($fetch->isProcessed()) {
                continue;
            }
            $requests[] = $this->getClient()->createRequest('GET', $fetch->getQuery()->createRequestPath(), null, null, array('exceptions' => false));
            $fetchesForFilled[] = $fetch;
        }

        if (count($requests) == 0) {
            return false;
        }

        $startTime = microtime(true);
        $responses = $this->getClient()->send($requests);

        $this->logMulti($requests, $responses, $startTime, LogLevel::DEBUG);

        $retry = false;
        foreach ($fetchesForFilled as $fetch) {
            $fetch->setResponseException(null); //reset exception because after retry request maybe done successful

            $response = array_shift($responses);
            if ($response && $response->getStatusCode() == 200) {
                $cacheKey = $fetch->prepareCacheKey();
                $fetch->getCache()->save($cacheKey, serialize($response));
                $fetch->setResult($this->convertResponse($response));
                $fetch->setProcessed(true);
            } else {
                $retry = $this->handleMultiFailedResponse($response, $fetch);
            }
        }
        return $retry;

    }

    /**
     * @param Response $response
     * @param Fetch $fetch
     * @return bool - return if response failed response candidate to retry
     */
    protected function handleMultiFailedResponse($response, $fetch)
    {
        if ($response) {
            $statusCode = $response->getStatusCode();
            $fetch->setResponseException($this->factoryException($statusCode, 'wrong status from api ' . $statusCode));
        } else {
            $fetch->setResponseException($this->factoryException(500, 'empty response from api'));
        }

        if ($response && $response->getStatusCode() == 502) {
            $retry = true;
        } else {
            $retry = false;
        }

        return $retry;
    }

    /**
     * @param Fetches $fetches
     */
    protected function getCacheResults(Fetches $fetches)
    {
        foreach ($fetches as $fetch) {
            /** @var Fetch $fetch */
            $cacheKey = $fetch->prepareCacheKey();

            $cacheResult = $fetch->getCache()->get($cacheKey);
            if ($cacheResult) {
                $this->logger->debug("get data from cache, query: " . $fetch->getQuery()->createRequestPath());
                $fetch->setResult($this->convertResponse(unserialize($cacheResult)));
                $fetch->setProcessed(true);
            }
        }
    }

    /**
     * @param Fetch $fetch
     * @throws Exception\NotFoundException
     * @throws Exception\InvalidRequestException
     * @throws Exception\FatalResponseException
     */
    public function send(Fetch $fetch)
    {
        $counterRetry = 0;
        do {
            $retry = false;

            try {
                $this->sendProcess($fetch);

            } catch (FatalResponseException $e) {
                if ($e->getCode() == 502) {
                    ++$counterRetry;
                    if ($counterRetry > self::MAX_RETRY) {
                        throw $e;
                    }
                    $retry = true;
                    $this->logger->info("retry send, url:" . $fetch->getQuery()->createRequestPath());
                    usleep(100);

                } else {
                    throw $e;
                }
            }

        } while ($retry);
    }

    protected function sendProcess(Fetch $fetch)
    {
        $requestPath = $fetch->getQuery()->createRequestPath();
        $cacheKey = $fetch->prepareCacheKey();

        $cache = $fetch->getCache();;

        $cacheResult = $cache->get($cacheKey);
        if ($cacheResult) {
            $this->logger->debug('get data from cache, query: ' . $requestPath);
            $fetch->setResult($this->convertResponse(unserialize($cacheResult)));
            return;
        }

        $startTime = microtime(true);

        $request = $this->getClient()->createRequest('GET', $requestPath);
        $response = null;
        try {
            $response = $this->getClient()->send($request);
            $this->log($request, $response, $startTime, LogLevel::DEBUG);

            $cache->save($cacheKey, serialize($response));

            $fetch->setResult($this->convertResponse($response));

        } catch (BadResponseException $e) {
            $this->handleException($e, $startTime);
        }
    }

    /**
     * @param Response $response
     * @return \stdClass
     */
    protected function convertResponse($response)
    {
        return json_decode($response->getBody(true));
    }

    /**
     * @param BadResponseException $e
     * @param $startTime
     * @throws Exception\FatalResponseException
     * @throws Exception\NotFoundException
     * @throws Exception\InvalidRequestException
     */
    protected function handleException(BadResponseException $e, $startTime)
    {
        $this->log($e->getRequest(), $e->getResponse(), $startTime);

        $statusCode = $e->getResponse()->getStatusCode();
        if ($statusCode == 404) {
            $exceptionMessage = (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '') . " 404 from api for request: " . $e->getResponse()->getRawHeaders();
        } else if ($statusCode == 400) {
            $exceptionMessage = (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '') . " 400 from api for request: " . $e->getResponse()->getRawHeaders();
        } else {
            $exceptionMessage = (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '') . " bad response from api (status: " . $statusCode . ") "
                . "for request: " . $e->getRequest()->getUrl();
        }

        throw $this->factoryException($statusCode, $exceptionMessage);
    }

    /**
     * return exception depends of API response status
     * @param $statusCode
     * @param $exceptionMessage
     * @return FatalResponseException|InvalidRequestException|NotFoundException
     */
    protected function factoryException($statusCode, $exceptionMessage)
    {
        if ($statusCode == 404) {
            return new NotFoundException($exceptionMessage);
        }

        if ($statusCode == 400) {
            return new InvalidRequestException($exceptionMessage);
        }

        return new FatalResponseException($exceptionMessage, $statusCode);
    }

    /**
     * @param RequestInterface $request
     * @param Response $response
     * @param $startTime
     * @param string $level - level form Psr\Log\LogLevel
     */
    protected function log($request, $response, $startTime, $level = LogLevel::INFO)
    {
        $url = $request->getUrl();
        $statusCode = $response->getStatusCode();

        if (!in_array($statusCode, array(200))) {
            $this->logger->error("Fail response: " . $statusCode . " (" . $response->getBody(true) . ") in " . $url
                . "\n" . $request->getRawHeaders()
                . "\n" . $response->getRawHeaders()
            );
        }

        $runTime = (string)$response->getHeader('X-Runtime');
        $endTime = microtime(true);
        $totalTime = ($endTime - $startTime);
        $timeInfo = '| runtime: ' . round($runTime, 3) . ' s, total: ' . round($totalTime, 3) . ' s';

        $this->logger->log($level, $url . ' ' . $timeInfo);
    }

    /**
     * @param RequestInterface[] $requests
     * @param Response[] $responses
     * @param $startTime
     * @param string $level - level form Psr\Log\LogLevel
     */
    protected function logMulti($requests, $responses, $startTime, $level = LogLevel::INFO)
    {
        $countRequest = count($requests);
        $endTime = microtime(true);
        foreach ($requests as $index => $request) {
            $response = $responses[$index];
            $url = $request->getUrl();
            $statusCode = $response->getStatusCode();

            if (!in_array($statusCode, array(200))) {
                $this->logger->error("Fail response: " . ($index + 1) . "/" . $countRequest
                    . " " . $statusCode . " (" . $response->getBody(true) . ") in " . $url
                    . "\n" . $request->getRawHeaders()
                    . "\n" . $response->getRawHeaders()
                );
            } else {
                $runTime = (string)$response->getHeader('X-Runtime');
                $totalTime = ($endTime - $startTime);
                $timeInfo = '| request runtime: ' . round($runTime, 3) . ' s, all requests: ' . round($totalTime, 3) . ' s';

                $this->logger->log($level, "Multi requests, request " . ($index + 1) . "/" . $countRequest
                    . " " . $url . ' ' . $timeInfo);
            }
        }
    }

    /**
     * @return Client
     */
    protected function getClient()
    {
        return $this->client;
    }

} 