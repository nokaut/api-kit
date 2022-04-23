<?php

namespace Nokaut\ApiKit\Converter;


use Nokaut\ApiKit\Collection\Shops;
use Nokaut\ApiKit\Entity\Shop;
use PHPUnit\Framework\TestCase;


class ShopsConverterTest extends TestCase
{
    public function testConvert()
    {
        $cut = new ShopsConverter();
        $correctObject = $this->getCorrectObject();
        /** @var Shops $shops */
        $shops = $cut->convert($correctObject);

        $this->assertCount(count($correctObject->shops), $shops);
        $this->assertInstanceOf('Nokaut\ApiKit\Collection\Shops', $shops);
        /** @var Shop $shop */
        foreach ($shops as $shop) {
            $this->assertInstanceOf('Nokaut\ApiKit\Entity\Shop', $shop);

            if ($shop->getId() == 4092) {
                $this->assertEquals('http://www.opineo.pl/opinie/gofans-pl', $shop->getOpineoRating()->getUrl());
            }
        }
    }

    private function getCorrectObject()
    {
        return json_decode('
            {
              "shops": [
                {
                  "id": 4092,
                  "name": "da capo - katarynki i Gracze",
                  "products_url": "/sklep:katarynki-jasky-pl.html",
                  "url_logo": "/s/632-201412241238343.jpg",
                  "opineo_rating": {
                    "rating": 0.0,
                    "rating_count": 0,
                    "url": "http://www.opineo.pl/opinie/gofans-pl"
                  }
                },
                {
                  "id": 8451,
                  "name": "dabar.pl",
                  "products_url": "/sklep:dabar-pl.html",
                  "url_logo": "/s/632-201412241238342.jpg",
                  "opineo_rating": {
                    "rating": 0.0,
                    "rating_count": 0,
                    "url": "http://www.opineo.pl/opinie/gofans-pl"
                  }
                },
                {
                  "id": 21827,
                  "name": "Dadin Maluchy to kochają",
                  "products_url": "/sklep:dadin-dadin-pl.html",
                  "url_logo": "/s/632-201412241238341.jpg",
                  "opineo_rating": {
                    "rating": 0.0,
                    "rating_count": 0,
                    "url": "http://www.opineo.pl/opinie/gofans-pl"
                  }
                },
                {
                  "id": 5332,
                  "name": "Dareckishop.eu",
                  "products_url": "/sklep:dareckishop-eu.html",
                  "url_logo": "/s/632-201412241238345.jpg",
                  "opineo_rating": {
                    "rating": 0.0,
                    "rating_count": 0,
                    "url": "http://www.opineo.pl/opinie/gofans-pl"
                  }
                },
                {
                  "id": 9338,
                  "name": "DaroTrans",
                  "products_url": "/sklep:darotrans-pl.html",
                  "url_logo": "/s/632-20141224123834.jpg",
                  "opineo_rating": {
                    "rating": 0.0,
                    "rating_count": 0,
                    "url": "http://www.opineo.pl/opinie/gofans-pl"
                  }
                }
              ]
            }
        ');
    }
}