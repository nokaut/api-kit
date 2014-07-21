<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 07.07.2014
 * Time: 12:53
 */

namespace Nokaut\ApiKit\Converter;


use Nokaut\ApiKit\Converter\Offer\PropertyConverter;
use Nokaut\ApiKit\Converter\Offer\ShopConverter;
use Nokaut\ApiKit\Entity\Offer;

class OfferConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $offer = new Offer();

        foreach ($object as $field => $value) {
            if (is_object($value) || is_array($value)) {
                $this->convertSubObject($offer, $field, $value);
            } else {
                $offer->set($field, $value);
            }
        }
        return $offer;
    }

    private function convertSubObject(Offer $offer, $field, $value)
    {
        switch ($field) {
            case 'properties':
                $offer->setProperties($this->convertProperties($value));
                break;
            case 'shop':
                $shopConverter = new ShopConverter();
                $offer->setShop($shopConverter->convert($value));
                break;
        }
    }

    /**
     * @param $propertiesFromApi
     * @return array
     */
    private function convertProperties($propertiesFromApi)
    {
        $propertyConverter = new PropertyConverter();
        $propertiesList = array();

        foreach ($propertiesFromApi as $propertyFromApi) {
            $propertiesList[] = $propertyConverter->convert($propertyFromApi);
        }

        return $propertiesList;
    }
} 