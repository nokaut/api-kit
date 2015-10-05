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
                    "name": "da capo - katarynki i Gracze"

                },
                {
                    "id": 23411,
                    "name": "DA-GROUP "

                },
                {
                    "id": 14133,
                    "name": "daadaa.pl"

                },
                {
                    "id": 22099,
                    "name": "Dabacom"

                },
                {
                    "id": 8451,
                    "name": "dabar.pl"
                }
            ]
        }
        ');
    }
}