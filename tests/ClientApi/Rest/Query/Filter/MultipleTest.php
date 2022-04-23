<?php

namespace Nokaut\ApiKit\ClientApi\Rest\Query\Filter;


class MultipleTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testAll($key, array $values, $expected)
    {
        $this->assertEquals($expected, new Multiple($key, $values));
    }

    public function dataProvider()
    {
        return array(
            array("cecha", array("jakieś tam filtr",2,3), "filter[cecha]=jakie%C5%9B+tam+filtr&filter[cecha]=2&filter[cecha]=3")
        );
    }
}
