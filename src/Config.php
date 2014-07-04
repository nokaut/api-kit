<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 03.07.2014
 * Time: 11:53
 */

namespace Nokaut\ApiKit;


use Nokaut\ApiKit\Cache\CacheInterface;
use Nokaut\ApiKit\Cache\NullCache;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class Config
{
    /**
     * @var CacheInterface
     */
    private $cache;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var string
     */
    private $apiUrl;
    /**
     * @var string
     */
    private $apiAccessToken;


    public function __construct()
    {
        $this->setLogger(new NullLogger());
        $this->setCache(new NullCache());
    }

    /**
     * @param string $apiAccessToken
     */
    public function setApiAccessToken($apiAccessToken)
    {
        $this->apiAccessToken = $apiAccessToken;
    }

    /**
     * @return string
     */
    public function getApiAccessToken()
    {
        return $this->apiAccessToken;
    }

    /**
     * @param string $apiUrl
     */
    public function setApiUrl($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    /**
     * @return string
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * @param CacheInterface $cache
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return CacheInterface
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Check if config is correct filled
     * @throws \InvalidArgumentException
     */
    public function validate()
    {
        if(empty($this->apiAccessToken)) {
            throw new \InvalidArgumentException("empty api access token, please set access token for API in Nokaut\\ApiKit\\Config");
        }

        if(empty($this->apiUrl)) {
            throw new \InvalidArgumentException("empty api URL, please set URL to API in Nokaut\\ApiKit\\Config");
        }

        if(empty($this->cache)) {
            throw new \InvalidArgumentException("cache not set, please cache mechanism in Nokaut\\ApiKit\\Config");
        }

        if(empty($this->logger)) {
            throw new \InvalidArgumentException("logger not set, please logger mechanism in Nokaut\\ApiKit\\Config");
        }
    }
} 