<?php

namespace Nokaut\ApiKit\Converter;


use Nokaut\ApiKit\Collection\Shops;
use PHPUnit_Framework_TestCase;

class ShopsConverterTest extends PHPUnit_Framework_TestCase
{
    public function testConvert()
    {
        $cut = new ShopsConverter();
        $correctObject = $this->getCorrectObject();
        /** @var Shops $shops */
        $shops = $cut->convert($correctObject);

        $this->assertCount(count($correctObject->shops), $shops);
        $this->assertInstanceOf('Nokaut\ApiKit\Collection\Shops', $shops);
        foreach ($shops as $shop) {
            $this->assertInstanceOf('Nokaut\ApiKit\Entity\Shop', $shop);
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
                  "products_url": "/sklep:katarynki-jasky-pl.html"
                },
                {
                  "id": 8451,
                  "name": "dabar.pl",
                  "products_url": "/sklep:dabar-pl.html"
                },
                {
                  "id": 21827,
                  "name": "Dadin Maluchy to kochają",
                  "products_url": "/sklep:dadin-dadin-pl.html"
                },
                {
                  "id": 5332,
                  "name": "Dareckishop.eu",
                  "products_url": "/sklep:dareckishop-eu.html"
                },
                {
                  "id": 9338,
                  "name": "DaroTrans",
                  "products_url": "/sklep:darotrans-pl.html"
                }
              ]
            }
        ');
    }
}