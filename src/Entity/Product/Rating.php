<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 26.07.2014
 * Time: 09:48
 */

namespace Nokaut\ApiKit\Entity\Product;


use Nokaut\ApiKit\Entity\EntityAbstract;

class Rating extends EntityAbstract
{
    /**
     * @var int
     */
    protected $rating;

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

}