<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 26.07.2014
 * Time: 09:59
 */

namespace Nokaut\ApiKit\Converter\Product;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Product\Rating;

class RatingConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $rating = new Rating();
        $rating->setRating($object->rating);
        return $rating;
    }
} 