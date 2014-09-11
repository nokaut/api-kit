<?php
/**
 * Created by PhpStorm.
 * User: dwilkiewicz
 * Date: 10.09.2014
 * Time: 13:31
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Query\Filter;


class SingleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testAll($key, $value, $expected)
    {
        $this->assertEquals($expected, new Single($key, $value));
    }

    public function dataProvider()
    {
        return array(
            array("cecha", "jakieś tam filtr", "filter[cecha]=jakie%C5%9B+tam+filtr"),
            array("property_9342", 23, "filter[property_9342]=23")
        );
    }
}
 