<?php

namespace Nokaut\ApiKit\Converter\Product\Rating;


use Exception;
use Nokaut\ApiKit\Entity\Product\Rating\Rate;
use PHPUnit\Framework\TestCase;
use stdClass;


class RateConverterTest extends TestCase
{

    public function testFromGetConvert()
    {
        $cut = new RateConverter();

        $correctObject = $this->getCorrectObject('fromGet');
        /** @var Rate[] $rate */
        $rate = $cut->convert($correctObject);
        $this->assertInstanceOf('Nokaut\ApiKit\Entity\Product\Rating\Rate', $rate);

        foreach ($correctObject as $field => $value) {
            $this->assertEquals($value, $rate->get($field));
        }
    }

    public function testFromCreatetConvert()
    {
        $cut = new RateConverter();

        $correctObject = $this->getCorrectObject('fromCreate');
        /** @var Rate[] $rate */
        $rate = $cut->convert($correctObject);
        $this->assertInstanceOf('Nokaut\ApiKit\Entity\Product\Rating\Rate', $rate);

        foreach ($correctObject as $field => $value) {
            if ($field != 'current_rating') {
                $this->assertEquals($value, $rate->get($field));
            }
        }
    }

    /**
     * @param $type
     * @return stdClass
     * @throws Exception
     */
    private function getCorrectObject($type)
    {
        $data = [
            'fromCreate' => '{"id":"560bc2759bc35f1036000003","rate":5,"comment":"super","current_rating":2.5}',
            'fromGet' => '{"id":"560bc2689bc35f2bd0000002","rate":0}'
        ];

        if (!isset($data[$type])) {
            throw new Exception('unknown type');
        }

        return json_decode($data[$type]);
    }
}