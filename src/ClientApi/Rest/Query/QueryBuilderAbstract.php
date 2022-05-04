<?php

namespace Nokaut\ApiKit\ClientApi\Rest\Query;

use Nokaut\ApiKit\ClientApi\Rest\Query\Filter;


abstract class QueryBuilderAbstract implements QueryBuilderInterface
{
    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var string
     */
    protected $body;

    /**
     * @var Filter\FilterInterface[]
     */
    private $filters = array();

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @param Filter\FilterInterface $filter
     */
    public function addFilter(Filter\FilterInterface $filter)
    {
        $this->filters[$filter->toHash()] = $filter;
    }

    /**
     * @return Filter\FilterInterface[]
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @return string
     * @throws \InvalidArgumentException
     */
    public function createFilterPart()
    {
        return implode("&", $this->filters);
    }
}