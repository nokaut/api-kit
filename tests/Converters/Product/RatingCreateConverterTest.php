<?php

namespace Nokaut\ApiKit\Converter\Product;


use Nokaut\ApiKit\Entity\Product\Rating;
use PHPUnit\Framework\TestCase;
use stdClass;


class RatingCreateConverterTest extends TestCase
{

    public function testConvert()
    {
        $cut = new RatingCreateConverter();
        $correctObject = $this->getCorrectObject();
        /** @var Rating $rating */
        $rating = $cut->convert($correctObject);

        $this->assertInstanceOf('Nokaut\ApiKit\Entity\Product\Rating', $rating);
        $this->assertEquals(2.0, $rating->getRating());
        $this->assertCount(1, $rating->getRates());

        foreach ($rating->getRates() as $rate) {
            $this->assertInstanceOf('Nokaut\ApiKit\Entity\Product\Rating\Rate', $rate);
        }
    }

    /**
     * @return stdClass
     */
    private function getCorrectObject()
    {
        return json_decode('{"id":"560bc2689bc35f2bd0000002","rate":2,"current_rating":2.0}');
    }
}