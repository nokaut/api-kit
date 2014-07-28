<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 17.07.2014
 * Time: 11:51
 */

namespace Nokaut\ApiKit\ClientApi\Rest;


use CommerceGuys\Guzzle\Plugin\Oauth2\Oauth2Plugin;
use Nokaut\ApiKit\Cache\NullCache;
use Nokaut\ApiKit\ClientApi\Rest\Query\QueryBuilderInterface;
use Nokaut\ApiKit\TestLogger;


class RestClientApiTest extends \PHPUnit_Framework_TestCase
{
    public function testSendMulti()
    {
        $queries[] = new TestQuery('http://jboss1-web/api/v2/product?fields=title&filter[id]=lllllllaptopy&limit=1');
        $queries[] = new TestQuery('http://jboss2-web/api/v2/products?fields=title&filter[url]=aparaty-cyfrowe&limit=1');
        $queries[] = new TestQuery('http://jboss3-web/api/v2/products?fields=title&filter[url]=rowery-gorskie&limit=1');

        $oauth2 = new Oauth2Plugin();
        $accessToken = array(
            'access_token' => ""
        );
        $oauth2->setAccessToken($accessToken);
        $cut = new RestClientApi(new NullCache(), new TestLogger(), $oauth2);

        $responses = $cut->sendMulti($queries);

        $this->assertTrue(is_null($responses[0]));
        $this->assertFalse(is_null($responses[1]));
        $this->assertFalse(is_null($responses[2]));
    }

}

class TestQuery implements QueryBuilderInterface
{
    private $testValue;

    public function __construct($testValue)
    {
        $this->testValue = $testValue;
    }


    public function createRequestPath()
    {
        return $this->testValue;
    }
}