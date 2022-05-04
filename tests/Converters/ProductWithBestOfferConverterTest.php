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
use PHPUnit\Framework\TestCase;
use stdClass;


class ProductWithBestOfferConverterTest extends TestCase
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
     * @param stdClass $correctObject
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
        $this->assertEquals($correctBestOffer->id, $bestOffer->getId());
        $this->assertEquals($correctBestOffer->shop->id, $bestOffer->getShop()->getId());
        $this->assertEquals($correctBestOffer->shop->name, $bestOffer->getShop()->getName());
        $this->assertEquals($correctBestOffer->shop->url_logo, $bestOffer->getShop()->getUrlLogo());
        $this->assertEquals($correctBestOffer->shop->opineo_rating->rating, $bestOffer->getShop()->getOpineoRating()->getRating());
        $this->assertEquals($correctBestOffer->shop->opineo_rating->rating_count, $bestOffer->getShop()->getOpineoRating()->getRatingCount());
        $this->assertEquals($correctBestOffer->shop->opineo_rating->url, $bestOffer->getShop()->getOpineoRating()->getUrl());
    }

    private function getCorrectObject()
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/fixtures/Converters/testProductWithBestOffer.json'));
    }
}