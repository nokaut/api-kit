<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 11:01
 */

namespace Nokaut\ApiKit\Converter\Metadata;


use Nokaut\ApiKit\Entity\EntityAbstract;
use Nokaut\ApiKit\Entity\Metadata\ProductsMetadata;

class ProductsMetadataConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testConvert()
    {
        $cut = new ProductsMetadataConverter();
        $correctObject = $this->getMetadataFromApi();

        /** @var ProductsMetadata $metadata */
        $metadata = $cut->convert($correctObject);

        foreach ($correctObject as $field => $value) {
            if (is_object($value) || is_array($value)) {
                $this->assertSubObject($field, $value, $metadata);
            } else {
                $this->assertEquals($value, $metadata->get($field));
            }
        }
    }

    /**
     * @param $field
     * @param $value
     * @param ProductsMetadata $metadata
     */
    private function assertSubObject($field, $value, $metadata)
    {
        switch ($field) {
            case 'sort':
                $this->assertArray($value, $metadata->get($field));
                break;
            case 'paging':
            case 'query':
                $this->assertObject($value, $metadata->get($field));
                break;
        }
    }

    /**
     * @param \stdClass $correctObject
     * @param EntityAbstract $objectToCheck
     */
    private function assertObject($correctObject, $objectToCheck)
    {
        foreach ($correctObject as $field => $value) {
            if (is_array($value)) {
                $this->assertArray($value, $objectToCheck->get($field));
            } else if (!is_object($value)) {
                $this->assertEquals($value, $objectToCheck->get($field));
            }
        }
    }

    private function assertArray($correctArray, $arrayToCheck)
    {
        foreach ($correctArray as $index => $item) {
            foreach ($item as $field => $value) {
                $this->assertEquals($value, $arrayToCheck[$index]->get($field));
            }
        }
    }

    private function getMetadataFromApi()
    {
        return json_decode('{
            "total": 1,
            "url": "/laptopy/producent:sony,cena:1530.00~2399.00,czestotliwosc-procesora:2.20;2.30;2.40;2.50;2.60;2.70;2.13;2.16;2.53;3.10;3.20+ghz,przekatna-ekranu:13.30;15.40,system-operacyjny:windows.html",
            "canonical": "/laptopy/producent:sony,cena:1530.00~2399.00.html",
            "quality": 100,
            "paging": {
                "current": 1,
                "total": 1,
                "url_template": "/laptopy/producent:sony,cena:1530.00~2399.00,czestotliwosc-procesora:2.20;2.30;2.40;2.50;2.60;2.70;2.13;2.16;2.53;3.10;3.20+ghz,przekatna-ekranu:13.30;15.40,system-operacyjny:windows--%d.html"
            },
            "sorts": [
                {
                    "id": null,
                    "name": "Domyślne",
                    "url": "/laptopy/producent:sony,cena:1530.00~2399.00,czestotliwosc-procesora:2.20;2.30;2.40;2.50;2.60;2.70;2.13;2.16;2.53;3.10;3.20+ghz,przekatna-ekranu:13.30;15.40,system-operacyjny:windows.html",
                    "is_filter": true
                },
                {
                    "id": "najmniej-ofert",
                    "name": "Najmniej ofert",
                    "url": "/laptopy/producent:sony,cena:1530.00~2399.00,czestotliwosc-procesora:2.20;2.30;2.40;2.50;2.60;2.70;2.13;2.16;2.53;3.10;3.20+ghz,przekatna-ekranu:13.30;15.40,system-operacyjny:windows--najmniej-ofert.html"
                },
                {
                    "id": "najpopularniejsze",
                    "name": "Najpopularniejsze",
                    "url": "/laptopy/producent:sony,cena:1530.00~2399.00,czestotliwosc-procesora:2.20;2.30;2.40;2.50;2.60;2.70;2.13;2.16;2.53;3.10;3.20+ghz,przekatna-ekranu:13.30;15.40,system-operacyjny:windows--najpopularniejsze.html"
                },
                {
                    "id": "najmniej-popularne",
                    "name": "Najmniej popularne",
                    "url": "/laptopy/producent:sony,cena:1530.00~2399.00,czestotliwosc-procesora:2.20;2.30;2.40;2.50;2.60;2.70;2.13;2.16;2.53;3.10;3.20+ghz,przekatna-ekranu:13.30;15.40,system-operacyjny:windows--najmniej-popularne.html"
                },
                {
                    "id": "od-a-do-z",
                    "name": "Od a do z",
                    "url": "/laptopy/producent:sony,cena:1530.00~2399.00,czestotliwosc-procesora:2.20;2.30;2.40;2.50;2.60;2.70;2.13;2.16;2.53;3.10;3.20+ghz,przekatna-ekranu:13.30;15.40,system-operacyjny:windows--od-a-do-z.html"
                },
                {
                    "id": "od-z-do-a",
                    "name": "Od z do a",
                    "url": "/laptopy/producent:sony,cena:1530.00~2399.00,czestotliwosc-procesora:2.20;2.30;2.40;2.50;2.60;2.70;2.13;2.16;2.53;3.10;3.20+ghz,przekatna-ekranu:13.30;15.40,system-operacyjny:windows--od-z-do-a.html"
                },
                {
                    "id": "najtansze",
                    "name": "Najtańsze",
                    "url": "/laptopy/producent:sony,cena:1530.00~2399.00,czestotliwosc-procesora:2.20;2.30;2.40;2.50;2.60;2.70;2.13;2.16;2.53;3.10;3.20+ghz,przekatna-ekranu:13.30;15.40,system-operacyjny:windows--najtansze.html"
                },
                {
                    "id": "najdrozsze",
                    "name": "Najdroższe",
                    "url": "/laptopy/producent:sony,cena:1530.00~2399.00,czestotliwosc-procesora:2.20;2.30;2.40;2.50;2.60;2.70;2.13;2.16;2.53;3.10;3.20+ghz,przekatna-ekranu:13.30;15.40,system-operacyjny:windows--najdrozsze.html"
                }
            ],
            "query": {
                "phrase": null,
                "facet_range": { },
                "offset": 0,
                "limit": 20,
                "sort": {
                    "category_sort3": "desc"
                }
            }

        }');
    }
}