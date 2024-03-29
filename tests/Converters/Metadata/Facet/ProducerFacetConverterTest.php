<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 14:10
 */

namespace Nokaut\ApiKit\Converter\Metadata\Facet;


use Nokaut\ApiKit\Entity\Metadata\Facet\ProducerFacet;
use PHPUnit\Framework\TestCase;

class ProducerFacetConverterTest extends TestCase
{
    public function testConvert()
    {
        $cut = new ProducerFacetConverter();
        $correctObject = $this->getMetadataFromApi();

        /** @var ProducerFacet $producerFacet */
        $producerFacet = $cut->convert($correctObject);

        foreach ($correctObject as $field => $value) {
            $this->assertEquals($value, $producerFacet->get($field));
        }
    }

    private function getMetadataFromApi()
    {
        return json_decode('
        {
            "id": "nikon",
            "name": "Nikon",
            "param": "nikon",
            "total": 77,
            "url": "/aparaty-fotograficzne/producent:nikon.html"
        }
        ');
    }
}