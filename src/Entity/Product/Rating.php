<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 26.07.2014
 * Time: 09:48
 */

namespace Nokaut\ApiKit\Entity\Product;


use Nokaut\ApiKit\Entity\EntityAbstract;
use Nokaut\ApiKit\Entity\Product\Rating\Rate;

class Rating extends EntityAbstract
{
    /**
     * @var int
     */
    protected $rating;

    /**
     * @var Rate[]
     */
    protected $rates = [];

    /**
     * @param int $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @return Rating\Rate[]
     */
    public function getRates()
    {
        return $this->rates;
    }

    /**
     * @param Rating\Rate[] $rates
     */
    public function setRates($rates)
    {
        $this->rates = $rates;
    }
}