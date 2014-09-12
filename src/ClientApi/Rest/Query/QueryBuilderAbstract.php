<?php

namespace Nokaut\ApiKit\ClientApi\Rest\Query;

use Nokaut\ApiKit\ClientApi\Rest\Query\Filter;


abstract class QueryBuilderAbstract implements QueryBuilderInterface
{
    /**
     * @var Filter\FilterInterface[]
     */
    private $filters = array();

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
     * @throws \InvalidArgumentException
     * @return string
     */
    public function createFilterPart()
    {
        return implode("&", $this->filters);
    }
}