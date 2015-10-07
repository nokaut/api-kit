<?php

namespace Nokaut\ApiKit\Converter\Product\Rating;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Product\Rating\Rate;

class RateConverter implements ConverterInterface
{

    public function convert(\stdClass $object)
    {
        $rate = new Rate();

        if (isset($object->id)) {
            $rate->setId($object->id);
        }

        if (isset($object->rate)) {
            $rate->setRate($object->rate);
        }

        if (isset($object->comment)) {
            $rate->setComment($object->comment);
        }

        if (isset($object->user)) {
            $rate->setUser($object->user);
        }

        if (isset($object->created_at)) {
            $rate->setCreatedAt($object->created_at);
        }

        if (isset($object->ip_address)) {
            $rate->setIpAddress($object->ip_address);
        }

        return $rate;
    }
}