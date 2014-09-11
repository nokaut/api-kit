<?php
/**
 * Created by PhpStorm.
 * User: dwilkiewicz
 * Date: 10.09.2014
 * Time: 15:21
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Query\Filter;


class SingleWithIndexAndOperatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testAll($key, $index, $operator, $value, $expected)
    {
        $this->assertEquals($expected, new SingleWithIndexAndOperator($key, $index, $operator, $value));
    }

    public function dataProvider()
    {
        return array(
            array("cecha", 0, "in", "jakieś tam filtr", "filter[cecha][0][in]=jakie%C5%9B+tam+filtr"),
            array("property_9342", 0, "gt", 23, "filter[property_9342][0][gt]=23")
        );
    }
}
 