<?php

namespace Nokaut\ApiKit\ClientApi\Rest\Query\Filter;

class Standalone implements FilterInterface
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $value;

    /**
     * @param string $key
     * @param string $value
     */
    function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function toHash()
    {
        return md5($this->key);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf("%s=%s", $this->key, urlencode($this->value));
    }
}