<?php

namespace Nokaut\ApiKit\Repository;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Nokaut\ApiKit\Collection\Shops;
use Nokaut\ApiKit\Config;
use Nokaut\ApiKit\Entity\Shop;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use stdClass;


class ShopsRepositoryTest extends TestCase
{
    /**
     * @var ShopsRepository
     */
    private $sut;

    /**
     * @var MockObject
     */
    private $clientApiMock;

    protected function setUp(): void
    {
        $oauth2 = "1/token111accessoauth2";
        $cacheMock = $this->getMockBuilder('Nokaut\ApiKit\Cache\CacheInterface')->getMock();
        $loggerMock = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $response = $this->getMockBuilder('\GuzzleHttp\Psr7\Response')->disableOriginalConstructor()->getMock();
        $response->expects($this->any())->method('getStatusCode')->will($this->returnValue(200));

        $mock = new MockHandler(array_fill(0, 1, $response));
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $this->clientApiMock = $this->getMockBuilder('Nokaut\ApiKit\ClientApi\Rest\RestClientApi')
            ->setConstructorArgs([$loggerMock, $oauth2])
            ->setMethods(['convertResponse', 'getClient', 'log', 'convertResponseToSaveCache'])
            ->getMock();
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
        $shops = $this->sut->fetchByNamePrefix('da', ShopsRepository::$fieldsAutoComplete, 5);

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

        /** @var Shops $shops */
        $shops = $this->sut->fetchByIds([12, 32, 54, 345, 43], ShopsRepository::$fieldsAll);

        $this->assertCount(5, $shops);
        /** @var Shop $shop */
        $shop = $shops->getItem(0);
        $this->assertEquals(4092, $shop->getId());
        $this->assertEquals('da capo - katarynki i Gracze', $shop->getName());
        $this->assertEquals('/sklep:katarynki-jasky-pl.html', $shop->getProductsUrl());
    }

    public function testFetchByIdFullData()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture('shopsFull')));

        /** @var Shops $shops */
        $shops = $this->sut->fetchByIds([632], ShopsRepository::$fieldsAll);

        $this->assertCount(1, $shops);
        /** @var Shop $shop */
        $shop = $shops->getItem(0);
        $this->assertEquals(632, $shop->getId());
        $this->assertEquals('desc123', $shop->getDescription());
        $this->assertEquals('RTV EURO AGD', $shop->getName());
        $this->assertEquals('http://url.shop', $shop->getUrlShop());
        $this->assertEquals('/sklep:euro-com-pl.html', $shop->getProductsUrl());
        $this->assertEquals('/s/632-20171004104140.png', $shop->getUrlLogo());
        $this->assertEquals('sklep123@euro123.com.pl', $shop->getCompany()->getEmail());
        $this->assertEquals('RTV EURO AGD Galeria Grodova', current($shop->getSalesPoints())->getName());
    }

    /**
     * @param $name
     * @return stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/fixtures/Repository/ShopsRepositoryTest/' . $name . '.json'));
    }
}