<?php

namespace Nokaut\ApiKit\Ext\Data\Entity\Filter;


class Category extends FilterAbstract
{
    /**
     * @var string
     */
    protected $url_base;

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
}