<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 07.07.2014
 * Time: 14:04
 */

namespace Nokaut\ApiKit\Converter;


use Nokaut\ApiKit\Entity\Offer;
use Nokaut\ApiKit\Entity\Offer\Property;
use Nokaut\ApiKit\Entity\Offer\Shop\OpineoRating;
use PHPUnit_Framework_TestCase;

class OfferConverterTest extends PHPUnit_Framework_TestCase
{

    public function testConvert()
    {
        $cut = new OfferConverter();
        $correctObject = $this->getCorrectObject();
        /** @var Offer $offer */
        $offer = $cut->convert($correctObject);

        foreach ($correctObject as $field => $value) {
            if (!is_object($value) && !is_array($value)) {
                $this->assertEquals($value, $offer->get($field));
            } else {
                $this->assertSubObject($field, $correctObject, $offer);
            }
        }
    }

    /**
     * @param string $field
     * @param \stdClass $correctObject
     * @param Offer $offer
     */
    private function assertSubObject($field, $correctObject, Offer $offer)
    {
        switch ($field) {
            case 'properties':
                $this->assertProperties($correctObject->$field, $offer->get($field));
                break;
            case 'shop':
                $this->assertShop($correctObject->$field, $offer->get($field));
                break;
            case 'photo_ids':
                $this->assertPhotoIds($correctObject->$field, $offer->get($field));
                break;
            default:
                $this->assertTrue(false, "not supported assert for field : " . $field);
        }
    }


    /**
     * @param array $correctObjectProperties
     * @param Property[] $productProperties
     */
    private function assertProperties(array $correctObjectProperties, array $productProperties)
    {
        $this->assertCount(count($correctObjectProperties), $productProperties);

        foreach ($correctObjectProperties as $index => $correctProperty) {
            foreach ($correctProperty as $field => $value) {
                $this->assertEquals($value, $productProperties[$index]->get($field));
            }
        }
    }

    private function assertShop($correctShop, Offer\Shop $shop)
    {
        foreach ($correctShop as $field => $value) {
            if ('opineo_rating' == $field) {
                $this->assertOpineoRating($value, $shop->getOpineoRating());
            } else {
                $this->assertEquals($value, $shop->get($field));
            }

        }
    }

    private function assertPhotoIds($correctPhotoIds, $photoIds)
    {
        foreach ($correctPhotoIds as $index => $correctPhotoId) {
            $this->assertEquals($correctPhotoId, $photoIds[$index]);
        }
    }

    private function assertOpineoRating($correctOpineoRating, OpineoRating $opineRating)
    {
        foreach ($correctOpineoRating as $field => $value) {
            $this->assertEquals($value, $opineRating->get($field));
        }
    }

    private function getCorrectObject()
    {
        return json_decode('
        {
            "id": "62e92fb1eda89d13fff280c4e91142db",
            "pattern_id": "523000da82fff05ced000001",
            "shop_id": 18089,
            "shop_product_id": "10054",
            "availability": 0,
            "category": "Tablety i smartfony/Apple/Smartfony",
            "description_html": "iPhone 5s 16GB LTE - Model A1457",
            "title": "Apple iPhone 5s 16GB, LTE, 4",
            "price": 2299,
            "producer": "Apple",
            "promo": null,
            "url": "http://www.skynet.pl/pl/apple-iphone-5s-16gb-lte-4-retina-8mp-isight-a7-m7-fv23-us-gwiezdna-szarosc.html",
            "warranty": null,
            "category_id": 687,
            "photo_id": "c842accc74af766e20f18616a98a03e6",
            "photo_ids": [],
            "cpc_value": 41,
            "expires_at": null,
            "blocked_at": null,
            "click_value": 0.41,
            "visible": true,
            "properties": [],
            "description": "iPhone 5s 16GB LTE - Model A1457Wersja - USPolskie menuPrzejsciówka w komplecieKiedyś nierealny. Dziś nieodzowny.Procesor o architekturze 64-bitowej. Czytnik linii papilarnych. Lepsza, szybsza kamera. System operacyjny stworzony dla architektury 64-bitowej. Każde z tych rozwiązań z osobna to wystarczający powód, by urządzenie nazwać przyszłościowym. iPhone ma je wszystkie. I dlatego bez wątpienia wyprzedza swój czas.Złoty standard. Dostępny także w srebrnym i szarym.iPhonea 5s wykonano z dokładnością co do mikrona. Każdy kontakt z nim nie pozostawia co do tego żadnych wątpliwości. Piękna aluminiowa obudowa. Smukłość metalu i szkła. Szafirowa osłona przycisku Początek. I jeszcze jedna, chroniąca kamerę iSight. Pod względem dizajnu i wykonania iPhone 5s nie ma sobie równych. Zachwyca smukłością i lekkością, na pierwszy rzut oka i kiedy weźmiesz go do ręki. Dostępny jest w trzech stylowych wersjach kolorystycznych: złotej, srebrnej i gwiezdnej szarości.Touch ID. Twój odcisk palca. Twój iPhone.Po swojego iPhone sięgasz dziesiątki razy dziennie, a pewnie jeszcze częściej. Wprowadzanie hasła za każdym razem zabiera Ci czas. Ale robisz to, bo chcesz mieć pewność, że nikt inny nie uzyska dostępu do Twojego iPhone",
            "click_url": "/Click/Offer/?click=sIqiiELxHmA8NonQGMTc0nmUfjlwdkz8lTNnZdJa9MYRo9NZtc6u5eTMKieaHjOcrrVGIQlEL8qjrktJGJ2foQ_O.API_1_2_",
            "shop": {
                "id": 18089,
                "name": "Skynet s.c.",
                "url_logo": "/s/18089.jpg",
                "high_quality": false,
                "opineo_rating": {
                    "rating": 9.4,
                    "rating_count": 1193,
                    "url": "http://www.opineo.pl/opinie/skynet-pl"
                }
            }
        }
        ');
    }
}