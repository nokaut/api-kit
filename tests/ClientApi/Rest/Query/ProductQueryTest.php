<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 04.07.2014
 * Time: 10:20
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Query;


class ProductQueryTest extends \PHPUnit_Framework_TestCase
{

    private static $baseUrl = "http://127.0.0.1:3401/api/v2/";

    public function testCreateRequestPathWithUrl()
    {
        $cut = new ProductQuery(self::$baseUrl);
        $cut->setFields(array('id,title'));
        $cut->setUrl("medycyna-konwencjonalna/kapsiplast-10-cm-x-15-cm-x-50-szt-0b4b1e6e6dbfecfd0d7b8fc844ff06a8");

        $url = $cut->createRequestPath();

        $this->assertEquals(self::$baseUrl . "product?fields=id,title&filter[url]=medycyna-konwencjonalna%2Fkapsiplast-10-cm-x-15-cm-x-50-szt-0b4b1e6e6dbfecfd0d7b8fc844ff06a8", $url);
    }

    public function testCreateRequestPathWithId()
    {
        $cut = new ProductQuery(self::$baseUrl);
        $cut->setFields(array('id,title'));
        $cut->setProductId("0b4b1e6e6dbfecfd0d7b8fc844ff06a8");

        $url = $cut->createRequestPath();

        $this->assertEquals(self::$baseUrl . "product/0b4b1e6e6dbfecfd0d7b8fc844ff06a8?fields=id,title", $url);
    }
} 