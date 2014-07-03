<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 03.07.2014
 * Time: 11:53
 */

namespace Nokaut\ApiKit;


use Nokaut\ApiKit\Cache\CacheInterface;
use Psr\Log\LoggerInterface;

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
     * @param \Nokaut\ApiKit\Cache\CacheInterface $cache
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return \Nokaut\ApiKit\Cache\CacheInterface
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return \Psr\Log\LoggerInterface
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
    }
} 