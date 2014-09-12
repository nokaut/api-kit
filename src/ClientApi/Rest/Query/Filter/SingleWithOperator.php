<?php

namespace Nokaut\ApiKit\ClientApi\Rest\Query\Filter;

class SingleWithOperator implements FilterInterface
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $operator;

    /**
     * @var string|array
     */
    private $value;

    /**
     * @param string $key
     * @param string $operator
     * @param string $value
     */
    public function __construct($key, $operator, $value)
    {
        $this->key = $key;
        $this->operator = $operator;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function toHash()
    {
        return md5($this->key.$this->operator);
    }

    public function __toString()
    {
        return sprintf("filter[%s][%s]=%s", $this->key, $this->operator, urlencode($this->value));
    }
}