<?php
/**
 * Created by PhpStorm.
 * User: dwilkiewicz
 * Date: 10.09.2014
 * Time: 13:31
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Query\Filter;


class SingleWithOperatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testAll($key, $operator, $value, $expected)
    {
        $this->assertEquals($expected, new SingleWithOperator($key, $operator, $value));
    }

    public function dataProvider()
    {
        return array(
            array("cecha", "in", "jakieś tam filtr", "filter[cecha][in]=jakie%C5%9B+tam+filtr"),
            array("property_9342","gt", 23, "filter[property_9342][gt]=23")
        );
    }
}
