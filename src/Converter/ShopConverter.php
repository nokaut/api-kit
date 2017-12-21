<?php

namespace Nokaut\ApiKit\Converter;


use Nokaut\ApiKit\Converter\Shop\CompanyConverter;
use Nokaut\ApiKit\Converter\Shop\OpineoRatingConverter;
use Nokaut\ApiKit\Converter\Shop\SalesPointConverter;
use Nokaut\ApiKit\Entity\Shop;

class ShopConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $shop = new Shop();
        foreach ($object as $field => $value) {
            if (is_object($value) || is_array($value)) {
                $this->convertSubObject($shop, $field, $value);
            } else {
                $shop->set($field, $value);
            }
        }

        return $shop;
    }

    protected function convertSubObject(Shop $shop, $filed, $value)
    {
        switch ($filed) {
            case 'opineo_rating':
                $opineoRatingConverter = new OpineoRatingConverter();
                $shop->setOpineoRating($opineoRatingConverter->convert($value));
                break;
            case 'sales_points':
                $salesPoints = [];
                $salesPointConverter = new SalesPointConverter();

                foreach ($value as $salesPointRaw) {
                    $salesPoints[] = $salesPointConverter->convert($salesPointRaw);
                }

                $shop->setSalesPoints($salesPoints);
                break;
            case 'company':
                $companyConverter = new CompanyConverter();
                $shop->setCompany($companyConverter->convert($value));
                break;
        }
    }
}