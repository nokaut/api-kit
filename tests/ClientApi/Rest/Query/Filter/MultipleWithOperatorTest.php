<?php
/**
 * Created by PhpStorm.
 * User: dwilkiewicz
 * Date: 10.09.2014
 * Time: 14:51
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Query\Filter;


class MultipleWithOperatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testAll($key, $operator, array $values, $expected)
    {
        $this->assertEquals($expected, new MultipleWithOperator($key, $operator, $values));
    }

    public function dataProvider()
    {
        return array(
            array("cecha", "in", array("jakieś tam filtr",2,3), "filter[cecha][in][]=jakie%C5%9B+tam+filtr&filter[cecha][in][]=2&filter[cecha][in][]=3")
        );
    }
}
 