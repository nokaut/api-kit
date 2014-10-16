<?php

namespace Nokaut\ApiKit\Ext\Data\Entity\Filter;


class Producer extends FilterAbstract
{
    /**
     * @var string
     */
    protected $url_base;

    /**
     * @var bool
     */
    protected $is_popular = false;

    /**
     * @param string $url_base
     */
    public function setUrlBase($url_base)
    {
        $this->url_base = $url_base;
    }

    /**
     * @return string
     */
    public function getUrlBase()
    {
        return $this->url_base;
    }

    /**
     * @param boolean $is_popular
     */
    public function setIsPopular($is_popular)
    {
        $this->is_popular = $is_popular;
    }

    /**
     * @return boolean
     */
    public function getIsPopular()
    {
        return $this->is_popular;
    }
} 