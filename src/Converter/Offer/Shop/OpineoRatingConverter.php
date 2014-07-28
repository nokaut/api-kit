<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 07.07.2014
 * Time: 12:58
 */

namespace Nokaut\ApiKit\Converter\Offer\Shop;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Offer\Shop\OpineoRating;

class OpineoRatingConverter implements ConverterInterface
{

    public function convert(\stdClass $object)
    {
        $opineoRating = new OpineoRating();
        foreach ($object as $field => $value) {
            $opineoRating->set($field, $value);
        }
        return $opineoRating;
    }
} 