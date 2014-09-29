<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 17.07.2014
 * Time: 13:36
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Fetch;


use Nokaut\ApiKit\Cache\CacheInterface;
use Nokaut\ApiKit\ClientApi\Rest\Query\QueryBuilderInterface;
use Nokaut\ApiKit\Collection\CollectionInterface;
use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\EntityAbstract;

class Fetch
{
    /**
     * @var QueryBuilderInterface
     */
    protected $query;
    /**
     * @var ConverterInterface
     */
    protected $converter;
    /**
     * @var CollectionInterface|EntityAbstract
     */
    protected $result;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * flag show if result was taken form cache/API
     * @var bool
     */
    protected $processed = false;

    /**
     * @param QueryBuilderInterface $query
     * @param ConverterInterface $converter
     * @param CacheInterface $cache
     */
    function __construct(QueryBuilderInterface $query, ConverterInterface $converter , CacheInterface $cache)
    {
        $this->query = $query;
        $this->converter = $converter;
        $this->cache = $cache;
    }


    /**
     * @param ConverterInterface $converter
     */
    public function setConverter($converter)
    {
        $this->converter = $converter;
    }

    /**
     * @return ConverterInterface
     */
    public function getConverter()
    {
        return $this->converter;
    }

    /**
     * @param QueryBuilderInterface $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * @return QueryBuilderInterface
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param \stdClass $result - raw result from ClientApi
     */
    public function setResult($result)
    {
        $this->result = $this->converter->convert($result);
    }

    /**
     * @return CollectionInterface|EntityAbstract
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param CacheInterface $cache
     */
    public function setCache($cache)
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
     * @return string
     */
    public function prepareCacheKey()
    {
        return 'api-' . md5($this->query->createRequestPath());
    }

    /**
     * @param boolean $processed
     */
    public function setProcessed($processed)
    {
        $this->processed = $processed;
    }

    /**
     * @return boolean
     */
    public function isProcessed()
    {
        return $this->processed;
    }


}