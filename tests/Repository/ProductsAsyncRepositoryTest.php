<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 24.09.2014
 * Time: 11:08
 */

namespace Nokaut\ApiKit\Repository;


use CommerceGuys\Guzzle\Plugin\Oauth2\Oauth2Plugin;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\ProductsFetch;
use Nokaut\ApiKit\Config;
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
        $oauth2 = "1/token111accessoauth2";
        $cacheMock = $this->getMock('Nokaut\ApiKit\Cache\CacheInterface');
        $loggerMock = $this->getMock('Psr\Log\LoggerInterface');

        $response = $this->getMockBuilder('\GuzzleHttp\Psr7\Response')->disableOriginalConstructor()->getMock();
        $response->expects($this->any())->method('getStatusCode')->will($this->returnValue(200));

        $request = $this->getMockBuilder('\GuzzleHttp\Psr7\Request')->disableOriginalConstructor()->getMock();

        $client = $this->getMockBuilder('\GuzzleHttp\Client')->disableOriginalConstructor()->getMock();
        $client->expects($this->any())->method('send')->will($this->returnValue(array($response)));
        $client->expects($this->any())->method('createRequest')->will($this->returnValue($request));

        $this->clientApiMock = $this->getMock(
            'Nokaut\ApiKit\ClientApi\Rest\RestClientApi',
            array('convertResponse', 'getClient', 'logMulti'),
            array($loggerMock, $oauth2)
        );

        $this->clientApiMock->expects($this->any())->method('getClient')
            ->will($this->returnValue($client));

        $config = new Config();
        $config->setCache($cacheMock);
        $config->setLogger($loggerMock);
        $config->setApiUrl("http://32213:454/api/v2/");

        $this->sut = new ProductsAsyncRepository($config, $this->clientApiMock);
    }

    public function testFetchProducts()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture('testFetchProducts')));

        /** @var ProductsFetch $productsFetch */
        $productsFetch = $this->sut->fetchProducts(2, ProductsRepository::$fieldsForList);
        $this->sut->fetchAllAsync();
        $this->assertCount(2, $productsFetch->getResult());
    }

    public function testFetchProductsByUrl()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture('testFetchProducts')));

        /** @var ProductsFetch $productsFetch */
        $productsFetch = $this->sut->fetchProductsByUrl(2, ProductsRepository::$fieldsForList);
        $this->sut->fetchAllAsync();
        $this->assertCount(2, $productsFetch->getResult());
    }

    public function testFetchProductsByUrlWithQuality()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture('testFetchProducts')));

        /** @var ProductsFetch $productsFetch */
        $productsFetch = $this->sut->fetchProductsByUrlWithQuality(2, ProductsRepository::$fieldsForList, 2, 60);
        $this->sut->fetchAllAsync();
        $this->assertCount(2, $productsFetch->getResult());
    }

    /**
     * @param $name
     * @return \stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/fixtures/Repository/ProductsRepositoryTest/' . $name . '.json'));
    }
} 