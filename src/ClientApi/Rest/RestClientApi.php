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
use Nokaut\ApiKit\Cache\CacheInterface;
use Nokaut\ApiKit\ClientApi\ClientApiInterface;
use Nokaut\ApiKit\ClientApi\Rest\Exception\FatalResponseException;
use Nokaut\ApiKit\ClientApi\Rest\Exception\InvalidRequestException;
use Nokaut\ApiKit\ClientApi\Rest\Exception\NotFoundException;
use Nokaut\ApiKit\ClientApi\Rest\Query\QueryBuilderInterface;
use Nokaut\ApiKit\Collection\CollectionInterface;
use Nokaut\ApiKit\Entity\EntityAbstract;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RestClientApi implements ClientApiInterface
{

    /**
     * @var \Guzzle\Http\Client
     */
    private $client;

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(CacheInterface $cache, LoggerInterface $logger, EventSubscriberInterface $auth)
    {
        $this->client = new Client();
        $this->client->addSubscriber($auth);
        $this->cache = $cache;

        $this->logger = $logger;
    }

    /**
     * @param QueryBuilderInterface $query
     * @return EntityAbstract|CollectionInterface
     *
     * @throws Exception\NotFoundException
     * @throws Exception\FatalResponseException
     */
    public function send(QueryBuilderInterface $query)
    {
        $cacheKey = 'api-' . md5($query->createRequestPath());

        $cacheResult = $this->cache->get($cacheKey);
        if ($cacheResult) {
            return $this->convertResponse(unserialize($cacheResult));
        }

        $startTime = microtime(true);

        $request = $this->client->createRequest('GET', $query->createRequestPath());
        $response = null;
        try {
            $response = $this->client->send($request);
            $this->log($request, $response, $startTime, LogLevel::DEBUG);

            $this->cache->save($cacheKey, serialize($response));
        } catch (BadResponseException $e) {
            $this->handleException($e, $startTime);
        }

        return $this->convertResponse($response);
    }

    /**
     * @param Response $response
     * @return \Guzzle\Http\EntityBodyInterface|string
     */
    private function convertResponse(Response $response)
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
    private function handleException(BadResponseException $e, $startTime)
    {
        $this->log($e->getRequest(), $e->getResponse(), $startTime);

        if($e->getResponse()->getStatusCode() == 404){
            throw new NotFoundException($_SERVER['REQUEST_URI'] . " 404 from api for request: " . $e->getResponse()->getRawHeaders());
        }

        if($e->getResponse()->getStatusCode() == 400){
            throw new InvalidRequestException($_SERVER['REQUEST_URI'] . " 400 from api for request: " . $e->getResponse()->getRawHeaders());
        }

        throw new FatalResponseException($_SERVER['REQUEST_URI'] . " bad response from api (status: " . $e->getResponse()->getStatusCode() . ") "
            . "for request: " . $e->getRequest()->getUrl());
    }

    /**
     * @param RequestInterface $request
     * @param \Guzzle\Http\Message\Response $response
     * @param $startTime
     * @param string $level - level form Psr\Log\LogLevel
     */
    private function log(RequestInterface $request, Response $response, $startTime, $level = LogLevel::INFO)
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
} 