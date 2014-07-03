<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.05.2014
 * Time: 11:38
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Query;


use PHPUnit_Framework_TestCase;

class CategoryQueryTest extends PHPUnit_Framework_TestCase
{
    private static $baseUrl = "http://127.0.0.1:3401/api/v2/";

    public function testCreateRequestPathWithUrl()
    {
        $cut = new CategoryQuery(self::$baseUrl);
        $cut->setFields(array('id', 'title'));
        $cut->setUrl('rowery-gorskie');

        $url = $cut->createRequestPath();

        $this->assertEquals(self::$baseUrl . "category?filter[url]=rowery-gorskie&fields=id,title", $url);
    }

    public function testCreateRequestPathWithId()
    {
        $cut = new CategoryQuery(self::$baseUrl);
        $cut->setFields(array('id', 'title'));
        $cut->setId('234');

        $url = $cut->createRequestPath();

        $this->assertEquals(self::$baseUrl . "categories/234?fields=id,title", $url);
    }
} 