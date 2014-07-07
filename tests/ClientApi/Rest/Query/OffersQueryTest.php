<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 07.07.2014
 * Time: 15:01
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Query;


class OffersQueryTest extends \PHPUnit_Framework_TestCase
{


    private static $baseUrl = "http://127.0.0.1:3401/api/v2/";

    public function testCreatePathWithProductId()
    {
        $cut = new OffersQuery(self::$baseUrl);
        $cut->setFields(array('id,title'));
        $cut->setLimit(2);
        $cut->setOffset(4);
        $cut->setOrder('vickrey', 'asc');
        $cut->setProductId("523000da82fff05ced000001");

        $url = $cut->createRequestPath();

        $this->assertEquals(self::$baseUrl . "products/523000da82fff05ced000001/offers?fields=id,title&limit=2&offset=4&sort[vickrey]=asc", $url);
    }
} 