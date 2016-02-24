<?php

namespace Nokaut\ApiKit\ClientApi\Rest\Query\Filter;

class Multiple implements FilterInterface
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var array
     */
    private $values;

    /**
     * @param string $key
     * @param array $values
     */
    public function __construct($key, array $values)
    {
        $this->key = $key;
        $this->values = $values;
    }

    /**
     * @return string
     */
    public function toHash()
    {
        return md5($this->key);
    }

    public function __toString()
    {
        $filter = array();

        foreach ($this->values as $value) {
            $filter[] = sprintf("filter[%s]=%s", $this->key, urlencode($value));
        }

        return implode("&", $filter);
    }
}