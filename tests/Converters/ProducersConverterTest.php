<?php

namespace Nokaut\ApiKit\Converter;


use Nokaut\ApiKit\Collection\Producers;
use PHPUnit\Framework\TestCase;


class ProducersConverterTest extends TestCase
{
    public function testConvert()
    {
        $cut = new ProducersConverter();
        $correctObject = $this->getCorrectObject();
        /** @var Producers $producers */
        $producers = $cut->convert($correctObject);

        $this->assertCount(count($correctObject->producers), $producers);
        $this->assertInstanceOf('Nokaut\ApiKit\Collection\Producers', $producers);
        foreach ($producers as $producer) {
            $this->assertInstanceOf('Nokaut\ApiKit\Entity\Producer', $producer);
        }
    }

    private function getCorrectObject()
    {
        return json_decode('
            {
              "producers": [
                {
                  "id": "samsung",
                  "name": "Samsung",
                  "products_url": "/producent:samsung.html"
                },
                {
                  "id": "salomon",
                  "name": "Salomon",
                  "products_url": "/producent:salomon.html"
                },
                {
                  "id": "sakolife",
                  "name": "Sakolife",
                  "products_url": "/producent:sakolife.html"
                },
                {
                  "id": "sanplast",
                  "name": "Sanplast",
                  "products_url": "/producent:sanplast.html"
                },
                {
                  "id": "sandisk",
                  "name": "Sandisk",
                  "products_url": "/producent:sandisk.html"
                }
              ]
            }
        ');
    }
}