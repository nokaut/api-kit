<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 17.07.2014
 * Time: 13:36
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Async;


use Nokaut\ApiKit\ClientApi\Rest\Query\QueryBuilderInterface;
use Nokaut\ApiKit\Collection\CollectionInterface;
use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\EntityAbstract;

class AsyncFetch
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
     * @param QueryBuilderInterface $query
     * @param ConverterInterface $converter
     */
    function __construct(QueryBuilderInterface $query, ConverterInterface $converter)
    {
        $this->query = $query;
        $this->converter = $converter;
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
     * @return CollectionInterface|EntityAbstract|CollectionInterface|EntityAbstract[]
     */
    public function getResult()
    {
        return $this->result;
    }

}