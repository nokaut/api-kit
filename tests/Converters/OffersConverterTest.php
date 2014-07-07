<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 07.07.2014
 * Time: 13:48
 */

namespace Nokaut\ApiKit\Converter;


use Nokaut\ApiKit\Collection\Offers;
use PHPUnit_Framework_TestCase;

class OffersConverterTest extends PHPUnit_Framework_TestCase
{

    public function testConvert()
    {
        $cut = new OffersConverter();
        $correctObject = $this->getCorrectObject();
        /** @var Offers $offers */
        $offers = $cut->convert($correctObject);

        $this->assertCount(count($correctObject->offers), $offers);
        $this->assertInstanceOf('Nokaut\ApiKit\Entity\Metadata\OffersMetadata', $offers->getMetadata());
        $this->assertInstanceOf('Nokaut\ApiKit\Collection\Offers', $offers);
        foreach ($offers as $offer) {
            $this->assertInstanceOf('Nokaut\ApiKit\Entity\Offer', $offer);
        }
    }

    private function getCorrectObject()
    {
        return json_decode('
        {
            "offers": [
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
                },
                {
                    "id": "69c583536caa384a71f625afe2a21507",
                    "pattern_id": "523000da82fff05ced000001",
                    "shop_id": 18089,
                    "shop_product_id": "7907",
                    "availability": 0,
                    "category": "Tablety i smartfony/Apple/Smartfony",
                    "description_html": "iPhone 5s 16GB LTE - Model A1457 Wersja wtyczki - UK",
                    "title": "Apple iPhone 5s 16GB, LTE, 4",
                    "price": 2319,
                    "producer": "Apple",
                    "promo": null,
                    "url": "http://www.skynet.pl/pl/apple-iphone-5s-16gb-lte-4-retina-8mp-isight-a7-m7-fv23-zloty.html",
                    "warranty": null,
                    "category_id": 687,
                    "photo_id": "0b5ecbbc68deb1912c83e4fb23514b71",
                    "photo_ids": null,
                    "cpc_value": 41,
                    "expires_at": null,
                    "blocked_at": null,
                    "click_value": 0.41,
                    "visible": true,
                    "properties": [],
                    "description": "iPhone 5s 16GB LTE - Model A1457Wersja wtyczki - UKPrzejściówka w zestawiePolskie menuKiedyś nierealny.",
                    "click_url": "/Click/Offer/?click=GfXQtAqZDE562gGPaKVKIVdxnuR4ihz47skmPybNWlAobp5EnYSjwARMZqD*hYACbqOqTp1VpEws42PPJod$8w_O.API_2_2_",
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
            ],
            "_metadata": {
                "price_min": 2298,
                "price_max": 3143,
                "total": 44,
                "availability_min": 0
            }
        }
        ');
    }
} 