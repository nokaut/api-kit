<?php

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\Rest\Fetch\ShopsFetch;
use Nokaut\ApiKit\Collection\Shops;
use Nokaut\ApiKit\Config;
use Nokaut\ApiKit\Entity\Shop;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

class ShopsAsyncRepositoryTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var ShopsRepository
     */
    private $sut;
    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $clientApiMock;

    public function setUp()
    {
        $oauth2 = "1/token111accessoauth2";
        $cacheMock = $this->createMock('Nokaut\ApiKit\Cache\CacheInterface');
        $loggerMock = $this->createMock('Psr\Log\LoggerInterface');

        $response = $this->getMockBuilder('\GuzzleHttp\Psr7\Response')->disableOriginalConstructor()->getMock();
        $response->expects($this->any())->method('getStatusCode')->will($this->returnValue(200));

        $request = $this->getMockBuilder('\GuzzleHttp\Psr7\Request')->disableOriginalConstructor()->getMock();

        $client = $this->getMockBuilder('\GuzzleHttp\Client')->disableOriginalConstructor()->getMock();
        $client->expects($this->any())->method('send')->will($this->returnValue(array($response)));
        $client->expects($this->any())->method('createRequest')->will($this->returnValue($request));

        $this->clientApiMock = $this->getMockBuilder('Nokaut\ApiKit\ClientApi\Rest\RestClientApi')
            ->setMethods(['convertResponse', 'getClient', 'log', 'logMulti', 'convertResponseToSaveCache'])
            ->setConstructorArgs([$loggerMock, $oauth2])
            ->getMock();

        $this->clientApiMock->expects($this->any())->method('getClient')
            ->will($this->returnValue($client));

        $config = new Config();
        $config->setCache($cacheMock);
        $config->setLogger($loggerMock);
        $config->setApiUrl("http://32213:454/api/v2/");

        $this->sut = new ShopsAsyncRepository($config, $this->clientApiMock);
    }

    public function testFetchByNamePrefix()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture('shops')));

        /** @var ShopsFetch $shopsFetch */
        $shopsFetch = $this->sut->fetchByNamePrefix('da', ShopsRepository::$fieldsAutoComplete, 5);
        $this->sut->fetchAllAsync();

        /** @var Shops $shops */
        $shops = $shopsFetch->getResult();

        $this->assertCount(5, $shops);
        /** @var Shop $shop */
        $shop = $shops->getItem(0);
        $this->assertEquals(4092, $shop->getId());
        $this->assertEquals('da capo - katarynki i Gracze', $shop->getName());
        $this->assertEquals('/sklep:katarynki-jasky-pl.html', $shop->getProductsUrl());
    }

    public function testFetchById()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture('shops')));

        /** @var ShopsFetch $shopsFetch */
        $shopsFetch = $this->sut->fetchByIds([12,32,54,345,43], ShopsRepository::$fieldsAll);
        $this->sut->fetchAllAsync();
        /** @var Shops $shops */
        $shops = $shopsFetch->getResult();

        $this->assertCount(5, $shops);
        /** @var Shop $shop */
        $shop = $shops->getItem(0);
        $this->assertEquals(4092, $shop->getId());
        $this->assertEquals('da capo - katarynki i Gracze', $shop->getName());
        $this->assertEquals('/sklep:katarynki-jasky-pl.html', $shop->getProductsUrl());
    }

    /**
     * @param $name
     * @return \stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/fixtures/Repository/ShopsRepositoryTest/' . $name . '.json'));
    }
}