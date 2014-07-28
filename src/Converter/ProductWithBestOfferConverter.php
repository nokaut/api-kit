<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 14.07.2014
 * Time: 09:17
 */

namespace Nokaut\ApiKit\Converter;


use Nokaut\ApiKit\Converter\Product\OfferWithBestPriceConverter;
use Nokaut\ApiKit\Entity\Product;
use Nokaut\ApiKit\Entity\ProductWithBestOffer;

class ProductWithBestOfferConverter extends ProductConverter
{
    public function convert(\stdClass $object)
    {
        $product = new ProductWithBestOffer();

        foreach ($object as $field => $value) {
            if (is_object($value) || is_array($value)) {
                $this->convertSubObjectWithBestPrice($product, $field, $value);
            } else {
                $product->set($field, $value);
            }
        }
        $this->sortPhotoIds($product);
        return $product;
    }

    protected function convertSubObjectWithBestPrice(ProductWithBestOffer $product, $field, $value)
    {
        switch ($field) {
            case 'offer_with_minimum_price':
                $offerWithBestPriceConverter = new OfferWithBestPriceConverter();
                $product->setOfferWithBestPrice($offerWithBestPriceConverter->convert($value));
                break;
            default:
                $this->convertSubObject($product, $field, $value);
        }
    }
} 