<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 07.07.2014
 * Time: 13:07
 */

namespace Nokaut\ApiKit\Entity\Metadata;


use Nokaut\ApiKit\Entity\EntityAbstract;

class OffersMetadata extends EntityAbstract
{
    /**
     * @var float
     */
    protected $price_min;
    /**
     * @var float
     */
    protected $price_max;
    /**
     * @var int
     */
    protected $total;
    /**
     * @var int
     */
    protected $availability_min;

    /**
     * @param int $availability_min
     */
    public function setAvailabilityMin($availability_min)
    {
        $this->availability_min = $availability_min;
    }

    /**
     * @return int
     */
    public function getAvailabilityMin()
    {
        return $this->availability_min;
    }

    /**
     * @param float $price_max
     */
    public function setPriceMax($price_max)
    {
        $this->price_max = $price_max;
    }

    /**
     * @return float
     */
    public function getPriceMax()
    {
        return $this->price_max;
    }

    /**
     * @param float $price_min
     */
    public function setPriceMin($price_min)
    {
        $this->price_min = $price_min;
    }

    /**
     * @return float
     */
    public function getPriceMin()
    {
        return $this->price_min;
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

}