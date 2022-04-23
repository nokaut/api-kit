<?php

namespace Nokaut\ApiKit\ClientApi\Rest\Query\Filter;


use PHPUnit\Framework\TestCase;

class StandaloneWithIndexTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testAll($key, $index, $value, $expected)
    {
        $this->assertEquals($expected, new StandaloneWithIndex($key, $index, $value));
    }

    public function dataProvider()
    {
        return array(
            array("cecha", "in", "jakieś tam filtr", "cecha[in]=jakie%C5%9B+tam+filtr"),
            array("elevate", "id", '55b36c34d7128701f30003cf', "elevate[id]=55b36c34d7128701f30003cf")
        );
    }
}
