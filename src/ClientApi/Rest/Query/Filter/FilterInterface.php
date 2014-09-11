<?php

namespace Nokaut\ApiKit\ClientApi\Rest\Query\Filter;


interface FilterInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function __toString();
}