<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 24.09.2014
 * Time: 11:08
 */

namespace Nokaut\ApiKit\Repository;


use CommerceGuys\Guzzle\Plugin\Oauth2\Oauth2Plugin;
use Nokaut\ApiKit\ClientApi\Rest\Async\ProductsAsyncFetch;
use PHPUnit_Framework_MockObject_MockObject;

class ProductsAsyncRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ProductsAsyncRepository
     */
    private $sut;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $clientApiMock;

    public function setUp()
    {
        $oauth2 = new Oauth2Plugin();
        $accessToken = array(
            'access_token' => '1111'
        );
        $oauth2->setAccessToken($accessToken);
        $this->clientApiMock = $this->getMock('Nokaut\ApiKit\ClientApi\ClientApiInterface', array('send', 'sendMulti', 'toHash'));

        $this->sut = new ProductsAsyncRepository("http://32213:454/api/v2/", $this->clientApiMock);
    }

    public function testFetchProducts()
    {
        $this->clientApiMock->expects($this->once())->method('sendMulti')
            ->will($this->returnValue($this->getJsonFixture('testFetchProducts')));

        /** @var ProductsAsyncFetch $productsFetch */
        $productsFetch = $this->sut->fetchProducts(2, ProductsRepository::$fieldsForList);
        $this->sut->fetchAllAsync();
        $this->assertCount(2, $productsFetch->getResult());
    }

    /**
     * @param $name
     * @return \stdClass
     */
    private function getJsonFixture($name)
    {
        return array(
            json_decode(file_get_contents(dirname(__DIR__) . '/fixtures/Repository/ProductsRepositoryTest/' . $name . '.json'))
        );
    }
} 