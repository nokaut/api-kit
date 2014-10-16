<?php

namespace Nokaut\ApiKit\Ext\Data\Entity\Filter;


abstract class FilterAbstract
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var int
     */
    protected $total;
    /**
     * @var string
     */
    protected $url;
    /**
     * @var bool
     */
    protected $is_filter = false;
    /**
     * @var bool
     */
    protected $is_nofollow = false;

    /**
     * @param boolean $is_filter
     */
    public function setIsFilter($is_filter)
    {
        $this->is_filter = $is_filter;
    }

    /**
     * @return boolean
     */
    public function getIsFilter()
    {
        return $this->is_filter;
    }

    /**
     * @param boolean $is_nofollow
     */
    public function setIsNofollow($is_nofollow)
    {
        $this->is_nofollow = $is_nofollow;
    }

    /**
     * @return boolean
     */
    public function getIsNofollow()
    {
        return $this->is_nofollow;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
} 