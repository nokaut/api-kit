<?php

namespace Nokaut\ApiKit\ClientApi\Rest\Query\Filter;

class MultipleWithOperator implements FilterInterface
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
     * @var array
     */
    private $values;

    /**
     * @param $key
     * @param $operator
     * @param $value
     */
    public function __construct($key, $operator, array $values)
    {
        $this->key = $key;
        $this->operator = $operator;
        $this->values = $values;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->key.$this->operator;
    }

    public function __toString()
    {
        $filter = array();

        foreach ($this->values as $value) {
            $filter[] = sprintf("filter[%s][%s][]=%s", $this->key, $this->operator, urlencode($value));
        }

        return implode("&", $filter);
    }
}