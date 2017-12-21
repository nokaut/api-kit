<?php

namespace Nokaut\ApiKit\Converter\Shop;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Shop\OpeningTime;

class OpeningTimeConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return OpeningTime
     */
    public function convert(\stdClass $object)
    {
        $openingTime = new OpeningTime();
        foreach ($object as $field => $value) {
            $openingTime->set($field, $value);
        }
        return $openingTime;
    }
}