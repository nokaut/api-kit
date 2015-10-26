<?php

namespace Nokaut\ApiKit\Converter\Product;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Converter\Product\Rating\RateConverter;
use Nokaut\ApiKit\Entity\Product\Rating;

class RatingCreateConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Rating
     */
    public function convert(\stdClass $object)
    {
        $rating = new Rating();

        if (isset($object->current_rating)) {
            $rating->setRating($object->current_rating);
        }

        $rateConverter = new RateConverter();
        $rating->setRates([$rateConverter->convert($object)]);

        return $rating;
    }
}