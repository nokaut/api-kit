<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 07.07.2014
 * Time: 13:12
 */

namespace Nokaut\ApiKit\Converter\Metadata;


use Nokaut\ApiKit\Converter\ConverterInterace;
use Nokaut\ApiKit\Entity\Metadata\OffersMetadata;

class OffersMetadataConverter implements ConverterInterace
{
    public function convert(\stdClass $object)
    {
        $offersMetadata = new OffersMetadata();

        foreach ($object as $field => $value) {
            $offersMetadata->set($field, $value);

        }
        return $offersMetadata;
    }
} 