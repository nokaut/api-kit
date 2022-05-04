<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 28.03.2014
 * Time: 23:04
 */

namespace Nokaut\ApiKit\ClientApi\Rest;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use Nokaut\ApiKit\ClientApi\ClientApiInterface;
use Nokaut\ApiKit\ClientApi\Rest\Auth\AuthHeader;
use Nokaut\ApiKit\ClientApi\Rest\Exception\FatalResponseException;
use Nokaut\ApiKit\ClientApi\Rest\Exception\InvalidRequestException;
use Nokaut\ApiKit\ClientApi\Rest\Exception\NotFoundException;
use Nokaut\ApiKit\ClientApi\Rest\Exception\UnprocessableEntityException;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\Fetch;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\Fetches;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class RestClientApi implements ClientApiInterface
{
    const MAX_RETRY = 2;
    const CONNECT_TIMEOUT = 5;
    const TIMEOUT = 10;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var string|AuthHeader
     */
    protected $authToken;

    /**
     * @param LoggerInterface $logger
     * @param string|AuthHeader $authToken
     * @param string $baseUrl
     * @param string $proxy
     */
    public function __construct(LoggerInterface $logger, $authToken, $baseUrl = '', $proxy = '')
    {
        $guzzleConfig = [
            RequestOptions::TIMEOUT => self::TIMEOUT,
            RequestOptions::CONNECT_TIMEOUT => self::CONNECT_TIMEOUT
        ];
        $guzzleConfig['headers'] = $this->getAuthorizationHeader($authToken);
        if ($baseUrl) {
            $guzzleConfig['base_uri'] = $baseUrl;
        }
        if ($proxy) {
            $guzzleConfig[\GuzzleHttp\RequestOptions::PROXY] = $proxy;
        }
        $this->client = new Client($guzzleConfig);
        $this->authToken = $authToken;
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
            $requests[] = new Request(
                $fetch->getQuery()->getMethod(),
                $fetch->getQuery()->createRequestPath(),
                $fetch->getQuery()->getHeaders(),
                $fetch->getQuery()->getBody()
            );
            $fetchesForFilled[] = $fetch;
        }

        if (count($requests) == 0) {
            return false;
        }

        $retry = false;
        $requestsCount = count($requests);
        $startTime = microtime(true);
        $pool = new Pool($this->getClient(), $requests, [
            'fulfilled' => function (Response $response, $index) use ($fetchesForFilled, $requests, $requestsCount, $startTime) {
                /** @var Fetch $fetch */
                $fetch = $fetchesForFilled[$index];
                $request = $requests[$index];
                $fetch->setResponseException(null); //reset exception because after retry request maybe done successful
                $additionalLogMessage = "Multi requests, request " . ($index + 1) . "/" . $requestsCount . " ";
                $this->handleMultiSuccessResponse($request, $response, $fetch, $startTime, $additionalLogMessage);
            },
            'rejected' => function (TransferException $reason, $index) use ($fetchesForFilled, $requestsCount, $startTime, &$retry) {
                /** @var Fetch $fetch */
                $fetch = $fetchesForFilled[$index];
                $additionalLogMessage = "Multi requests, request " . ($index + 1) . "/" . $requestsCount . " "
                    . $reason->getMessage() . "\n";
                $retry = $this->handleMultiFailedResponse($reason, $fetch, $startTime, $additionalLogMessage);
            },
        ]);
        $promise = $pool->promise();
        $promise->wait();

        return $retry;

    }

    /**
     * @param Request $request
     * @param Response $response
     * @param Fetch $fetch
     * @param $startTime
     * @param string $additionalLogMessage
     */
    protected function handleMultiSuccessResponse($request, $response, $fetch, $startTime, $additionalLogMessage)
    {
        $this->log($request, $response, $startTime, LogLevel::DEBUG, $additionalLogMessage);

        $cacheKey = $fetch->prepareCacheKey();
        $fetch->getCache()->save($cacheKey, $this->convertResponseToSaveCache($response));
        $fetch->setResult($this->convertResponse($response));
        $fetch->setProcessed(true);
    }

    /**
     * https://docs.guzzlephp.org/en/latest/quickstart.html#exceptions
     *
     * @param TransferException $reason
     * @param Fetch $fetch
     * @param $startTime
     * @param string $additionalLogMessage
     * @return bool - return if response failed response candidate to retry
     */
    protected function handleMultiFailedResponse(TransferException $reason, $fetch, $startTime, $additionalLogMessage = '')
    {
        $logLevel = LogLevel::ERROR;

        $request = $reason->getRequest();
        $response = method_exists($reason, 'getResponse') ? $reason->getResponse() : null;

        if ($response) {
            $statusCode = $response->getStatusCode();
            if ($statusCode == 404) {
                $logLevel = LogLevel::INFO;
            }
            $fetch->setResponseException($this->factoryException($statusCode, 'wrong status from api ' . $statusCode));

            $additionalLogMessage .= "Fail response: "
                . " " . $statusCode . " (" . $response->getBody() . ") in " . $request->getUri()
                . "\n" . print_r($request->getHeaders(), true) . "\n"
                . "\n" . print_r($response->getHeaders(), true) . "\n";
        } else {
            $fetch->setResponseException($this->factoryException(500, $reason->getMessage()));

            $additionalLogMessage .= "Fail response: "
                . " empty response from api in " . $request->getUri()
                . "\n" . print_r($request->getHeaders(), true) . "\n";
        }

        $this->log($request, $response, $startTime, $logLevel, $additionalLogMessage);

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
                $fetch->setResult($this->convertCacheResponse($cacheResult));
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
            $fetch->setResult($this->convertCacheResponse($cacheResult));
            return;
        }

        $startTime = microtime(true);

        $request = new Request(
            $fetch->getQuery()->getMethod(),
            $requestPath,
            $fetch->getQuery()->getHeaders(),
            $fetch->getQuery()->getBody()
        );
        $response = null;
        try {
            $response = $this->getClient()->send($request);
            $this->log($request, $response, $startTime);

            $cache->save($cacheKey, $this->convertResponseToSaveCache($response));

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
        return json_decode($response->getBody());
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
        $response = $e->getResponse();
        $request = $e->getRequest();
        $statusCode = $response->getStatusCode();

        $additionalLogMessage = "Fail response: " . $statusCode . " (" . $response->getBody() . ") "
            . "\n" . $request->getUri()
            . "\n" . print_r($request->getHeaders(), true) . "\n";


        $logLevel = LogLevel::ERROR;
        if ($statusCode == 404) {
            $logLevel = LogLevel::INFO;
        }

        $this->log($e->getRequest(), $e->getResponse(), $startTime, $logLevel, $additionalLogMessage);

        $statusCode = $e->getResponse()->getStatusCode();
        if ($statusCode == 404 || $statusCode == 400) {
            $exceptionMessage = (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '') . " " . $statusCode . " from api for request: " . $request->getUri();
        } else {
            $exceptionMessage = (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '') . " bad response from api (status: " . $statusCode . ") "
                . "for request: " . $request->getUri();
        }

        throw $this->factoryException($statusCode, $exceptionMessage);
    }

    /**
     * return exception depends of API response status
     * @param $statusCode
     * @param $exceptionMessage
     * @return FatalResponseException|InvalidRequestException|NotFoundException|UnprocessableEntityException
     */
    protected function factoryException($statusCode, $exceptionMessage)
    {
        if ($statusCode == 404) {
            return new NotFoundException($exceptionMessage);
        }

        if ($statusCode == 400) {
            return new InvalidRequestException($exceptionMessage);
        }

        if ($statusCode == 422) {
            return new UnprocessableEntityException($exceptionMessage);
        }

        return new FatalResponseException($exceptionMessage, $statusCode);
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param $startTime
     * @param string $level - level form Psr\Log\LogLevel
     * @param string $additionalMessage
     */
    protected function log($request, $response, $startTime, $level = LogLevel::DEBUG, $additionalMessage = '')
    {
        $url = $request->getUri();

        if ($additionalMessage) {
            $additionalMessage = $additionalMessage . ' ';
        }
        $apiStatusMessage = $response ? 'status from API: ' . $response->getStatusCode() . ' ' : 'empty response ';

        $timeInfo = '';
        if ($response) {
            $runTime = (string)$response->getHeaderLine('X-Runtime');
            $endTime = microtime(true);
            $totalTime = ($endTime - $startTime);
            $timeInfo .= '| runtime: ' . round($runTime, 3) . ' s, total: ' . round($totalTime, 3) . ' s';
        }

        $this->logger->log($level, $additionalMessage . $apiStatusMessage . $url . ' ' . $timeInfo);
    }

    /**
     * @return Client
     */
    protected function getClient()
    {
        return $this->client;
    }

    private function convertCacheResponse($cacheResult)
    {
        return json_decode($cacheResult);
    }

    /**
     * @param Response $response
     * @return mixed
     */
    protected function convertResponseToSaveCache($response)
    {
        return $response->getBody()->__toString();
    }

    /**
     * @param $authToken
     * @return array
     */
    private function getAuthorizationHeader($authToken)
    {
        if ($authToken instanceof AuthHeader) {
            return $authToken->getAuthHeader();
        }
        return ['Authorization' => 'Bearer ' . $authToken];
    }

} 