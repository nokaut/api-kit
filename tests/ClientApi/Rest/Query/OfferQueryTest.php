<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 22.09.2014
 * Time: 11:47
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Query;


class OfferQueryTest extends \PHPUnit_Framework_TestCase
{


    private static $baseUrl = "http://127.0.0.1:3401/api/v2/";

    public function testCreatePathWithProductId()
    {
        $cut = new OfferQuery(self::$baseUrl);
        $cut->setFields(array('id,title'));
        $cut->setId("523000da82fff05ced000001");

        $url = $cut->createRequestPath();

        $this->assertEquals(self::$baseUrl . "offers/523000da82fff05ced000001?fields=id,title", $url);
    }
} 