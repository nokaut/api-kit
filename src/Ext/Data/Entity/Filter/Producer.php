<?php

namespace Nokaut\ApiKit\Ext\Data\Entity\Filter;


class Producer extends FilterAbstract
{
    /**
     * @var bool
     */
    protected $is_popular = false;

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