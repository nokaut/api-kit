<?php

namespace Nokaut\ApiKit\Repository;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Nokaut\ApiKit\Collection\Producers;
use Nokaut\ApiKit\Config;
use Nokaut\ApiKit\Entity\Producer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use stdClass;


class ProducersRepositoryTest extends TestCase
{

    /**
     * @var ProducersRepository
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

        $this->sut = new ProducersRepository($config, $this->clientApiMock);
    }

    public function testFetchByNamePrefix()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture('producers')));

        /** @var Producers $producers */
        $producers = $this->sut->fetchByNamePrefix('sa', ProducersRepository::$fieldsAll, 5);

        $this->assertCount(5, $producers);
        /** @var Producer $producer */
        $producer = $producers->getItem(0);
        $this->assertEquals('samsung', $producer->getId());
        $this->assertEquals('Samsung', $producer->getName());
        $this->assertEquals('/producent:samsung.html', $producer->getProductsUrl());
    }

    public function testFetchByIds()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture('producers')));

        /** @var Producers $producers */
        $producers = $this->sut->fetchByIds([12, 32, 54, 345, 43], ProducersAsyncRepository::$fieldsAll);

        $this->assertCount(5, $producers);
        /** @var Producer $producer */
        $producer = $producers->getItem(0);
        $this->assertEquals('samsung', $producer->getId());
        $this->assertEquals('Samsung', $producer->getName());
        $this->assertEquals('/producent:samsung.html', $producer->getProductsUrl());
    }

    /**
     * @param $name
     * @return stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/fixtures/Repository/ProducersRepositoryTest/' . $name . '.json'));
    }
}