<?php

namespace Nokaut\ApiKit\ClientApi\Rest\Query\Filter;

class SingleWithIndexAndOperator implements FilterInterface
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $index;

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
     * @param string $index
     * @param string $operator
     * @param string $value
     */
    public function __construct($key, $index, $operator, $value)
    {
        $this->key = $key;
        $this->index = $index;
        $this->operator = $operator;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function toHash()
    {
        return md5($this->key.$this->index.$this->operator);
    }

    public function __toString()
    {
        return sprintf("filter[%s][%s][%s]=%s", $this->key, $this->index, $this->operator, urlencode($this->value));
    }
}