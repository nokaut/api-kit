<?php

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\Collection\Shops;
use Nokaut\ApiKit\Config;
use Nokaut\ApiKit\Entity\Shop;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

class ShopsRepositoryTest extends PHPUnit_Framework_TestCase
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
        $cacheMock = $this->getMock('Nokaut\ApiKit\Cache\CacheInterface');
        $loggerMock = $this->getMock('Psr\Log\LoggerInterface');
        $client = $this->getMockBuilder('\GuzzleHttp\Client')->disableOriginalConstructor()->getMock();
        $this->clientApiMock = $this->getMock(
            'Nokaut\ApiKit\ClientApi\Rest\RestClientApi',
            array('convertResponse', 'getClient', 'log', 'convertResponseToSaveCache'),
            array($loggerMock, $oauth2)
        );
        $this->clientApiMock->expects($this->any())->method('getClient')
            ->will($this->returnValue($client));

        $config = new Config();
        $config->setCache($cacheMock);
        $config->setLogger($loggerMock);
        $config->setApiUrl("http://32213:454/api/v2/");

        $this->sut = new ShopsRepository($config, $this->clientApiMock);
    }

    public function testFetchByNamePrefix()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture('shops')));

        /** @var Shops $shops */
        $shops = $this->sut->fetchByNamePrefix('da', 5);

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