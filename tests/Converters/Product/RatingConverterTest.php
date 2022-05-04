<?php

namespace Nokaut\ApiKit\Converter\Product;


use Nokaut\ApiKit\Entity\Product\Rating;
use PHPUnit\Framework\TestCase;
use stdClass;


class RatingConverterTest extends TestCase
{

    public function testConvert()
    {
        $cut = new RatingConverter();
        $correctObject = $this->getCorrectObject();
        /** @var Rating $rating */
        $rating = $cut->convert($correctObject);

        $this->assertInstanceOf('Nokaut\ApiKit\Entity\Product\Rating', $rating);
        $this->assertEquals(2.5, $rating->getRating());
        $this->assertCount(2, $rating->getRates());

        foreach ($rating->getRates() as $rate) {
            $this->assertInstanceOf('Nokaut\ApiKit\Entity\Product\Rating\Rate', $rate);
        }
    }

    /**
     * @return stdClass
     */
    private function getCorrectObject()
    {
        return json_decode('{"current_rating":2.5,"rates":[{"id":"560bc2689bc35f2bd0000002","rate":0},{"id":"560bc2759bc35f1036000003","rate":5,"comment":"super"}]}');
    }
}