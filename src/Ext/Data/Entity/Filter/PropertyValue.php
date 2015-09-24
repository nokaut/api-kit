<?php

namespace Nokaut\ApiKit\Ext\Data\Entity\Filter;


class PropertyValue extends FilterAbstract
{
    /**
     * @var string
     */
    protected $param;

    /**
     * @return string
     */
    public function getParam()
    {
        return $this->param;
    }

    /**
     * @param string $param
     */
    public function setParam($param)
    {
        $this->param = $param;
    }
} 