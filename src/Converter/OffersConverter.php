<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 07.07.2014
 * Time: 13:04
 */

namespace Nokaut\ApiKit\Converter;


use Nokaut\ApiKit\Collection\Offers;
use Nokaut\ApiKit\Converter\Metadata\OffersMetadataConverter;
use Nokaut\ApiKit\Entity\Metadata\OffersMetadata;

class OffersConverter implements ConverterInterface
{

    /**
     * @param \stdClass $object
     * @return Offers
     */
    public function convert(\stdClass $object)
    {
        $offerConverter = new OfferConverter();
        $offersArray = array();
        foreach ($object->offers as $offerObject) {
            $offersArray[] = $offerConverter->convert($offerObject);
        }

        $offers = new Offers($offersArray);

        $metadata = $this->convertMetadata($object);
        if ($metadata) {
            $offers->setMetadata($metadata);
        }

        return $offers;
    }

    /**
     * @param \stdClass $object
     * @return OffersMetadata
     */
    protected function convertMetadata(\stdClass $object)
    {
        if (isset($object->_metadata)) {
            $metadataConverter = new OffersMetadataConverter();
            return $metadataConverter->convert($object->_metadata);
        }
    }
} 