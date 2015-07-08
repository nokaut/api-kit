<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 14.07.2014
 * Time: 09:19
 */

namespace Nokaut\ApiKit\Converter\Product;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Converter\Offer\ShopConverter as OfferShopConverter;
use Nokaut\ApiKit\Entity\Product\OfferWithBestPrice;

class OfferWithBestPriceConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $offerWithBestPrice = new OfferWithBestPrice();

        foreach ($object as $field => $value) {
            if (is_object($value) || is_array($value)) {
                $this->convertSubObjectWithBestPrice($offerWithBestPrice, $field, $value);
            } else {
                $offerWithBestPrice->set($field, $value);
            }
        }
        return $offerWithBestPrice;
    }

    protected function convertSubObjectWithBestPrice(OfferWithBestPrice $offerWithBestPrice, $field, $value)
    {
        switch ($field) {
            case 'shop':
                $shopConverter = new OfferShopConverter();
                $offerWithBestPrice->setShop($shopConverter->convert($value));
                break;
        }
    }

} 