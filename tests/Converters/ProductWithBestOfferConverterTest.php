<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 14.07.2014
 * Time: 09:26
 */

namespace Nokaut\ApiKit\Converter;


use Nokaut\ApiKit\Entity\Product\OfferWithBestPrice;
use Nokaut\ApiKit\Entity\ProductWithBestOffer;
use PHPUnit_Framework_TestCase;

class ProductWithBestOfferConverterTest extends PHPUnit_Framework_TestCase
{
    public function testConverter()
    {
        $cut = new ProductWithBestOfferConverter();
        $correctObject = $this->getCorrectObject();
        /** @var ProductWithBestOffer $product */
        $product = $cut->convert($correctObject);

        foreach ($correctObject as $field => $value) {
            if (!is_object($value) && !is_array($value)) {
                $this->assertEquals($value, $product->get($field));
            } else {
                $this->assertSubObject($field, $correctObject, $product);
            }
        }
    }

    /**
     * @param string $field
     * @param \stdClass $correctObject
     * @param ProductWithBestOffer $product
     */
    private function assertSubObject($field, $correctObject, ProductWithBestOffer $product)
    {
        switch ($field) {
            case 'offer_with_minimum_price':
                $this->assertBestOffer($correctObject->$field, $product->get($field));
                break;
            default:
                $this->assertTrue(false, "not supported assert for field : " . $field);
        }
    }

    private function assertBestOffer($correctBestOffer, OfferWithBestPrice $bestOffer)
    {
        $this->assertEquals($correctBestOffer->click_url, $bestOffer->getClickUrl());
        $this->assertEquals($correctBestOffer->price, $bestOffer->getPrice());
    }

    private function getCorrectObject()
    {
        return json_decode('{
            "id": "50ab37b982fff088e8000ee9",
            "title": "Apple iPad mini 64GB",
            "url": "tablety/apple-ipad-mini-64gb",
            "offer_with_minimum_price": {
                "click_url": "/Click/Offer/?click=NycoA70pboxDHgLjorC2iKqMwEgIKlOorEflQhdXfzevyV1wMblHBaxf$P3YHaxmZG806J5khwe9Qkex8zhC6oOgyzKFfwUBCYzF*E$3rcw_P.API_1_1_category_sort3desc",
                "price": 490.00
            }
        }');
    }
}