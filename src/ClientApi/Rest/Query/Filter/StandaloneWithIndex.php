<?php

namespace Nokaut\ApiKit\ClientApi\Rest\Query\Filter;

class StandaloneWithIndex implements FilterInterface
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
     * @var string
     */
    private $index;

    /**
     * @param string $key
     * @param string $index
     * @param string $value
     */
    function __construct($key, $index, $value)
    {
        $this->key = $key;
        $this->index = $index;
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
        return sprintf("%s[%s]=%s", $this->key, $this->index, urlencode($this->value));
    }
}