<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 14:20
 */

namespace Nokaut\ApiKit\Entity\Metadata\Facet;


use Nokaut\ApiKit\Entity\EntityAbstract;

class PriceFacet extends EntityAbstract
{
    /**
     * @var float
     */
    protected $min;
    /**
     * @var float
     */
    protected $max;
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
     * @param float $max
     */
    public function setMax($max)
    {
        $this->max = $max;
    }

    /**
     * @return float
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @param float $min
     */
    public function setMin($min)
    {
        $this->min = $min;
    }

    /**
     * @return float
     */
    public function getMin()
    {
        return $this->min;
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

}