<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 07.07.2014
 * Time: 13:17
 */

namespace Nokaut\ApiKit\Converter\Metadata;


use Nokaut\ApiKit\Entity\Metadata\OffersMetadata;

class OffersMetadataConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testConvert()
    {
        $cut = new OffersMetadataConverter();
        $correctObject = $this->getMetadataFromApi();

        /** @var OffersMetadata $metadata */
        $metadata = $cut->convert($correctObject);

        foreach ($correctObject as $field => $value) {
            $this->assertEquals($value, $metadata->get($field));
        }
    }

    private function getMetadataFromApi()
    {
        return json_decode('{
            "price_min": 2298,
            "price_max": 3143,
            "total": 46,
            "availability_min": 0
        }');
    }
} 