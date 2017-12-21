<?php

namespace Nokaut\ApiKit\Converter\Shop;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Shop\SalesPoint;

class SalesPointConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return SalesPoint
     */
    public function convert(\stdClass $object)
    {
        $salesPoint = new SalesPoint();
        foreach ($object as $field => $value) {
            if (is_object($value) || is_array($value)) {
                $this->convertSubObject($salesPoint, $field, $value);
            } else {
                $salesPoint->set($field, $value);
            }
        }

        return $salesPoint;
    }

    /**
     * @param SalesPoint $salesPoint
     * @param $field
     * @param $value
     */
    protected function convertSubObject(SalesPoint $salesPoint, $field, $value)
    {
        switch ($field) {
            case 'address':
                $addressConverter = new AddressConverter();
                $salesPoint->setAddress($addressConverter->convert($value));
                break;
            case 'opening_times':
                $openingTimes = [];
                $openingTimeConverter = new OpeningTimeConverter();

                foreach ($value as $openingTimeRaw) {
                    $openingTimes[] = $openingTimeConverter->convert($openingTimeRaw);
                }

                $salesPoint->setOpeningTimes($openingTimes);
                break;
        }
    }
}