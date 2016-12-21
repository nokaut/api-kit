<?php

namespace Nokaut\ApiKit\Converter\Shop;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Shop\OpineoRating;

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