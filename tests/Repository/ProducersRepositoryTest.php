<?php

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\Collection\Producers;
use Nokaut\ApiKit\Config;
use Nokaut\ApiKit\Entity\Producer;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

class ProducersRepositoryTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var ProducersRepository
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
        $client = $this->getMockBuilder('\GuzzleHttp\Client')->disableOriginalConstructor()->getMock();
        $this->clientApiMock = $this->getMockBuilder('Nokaut\ApiKit\ClientApi\Rest\RestClientApi')
            ->setMethods(['convertResponse', 'getClient', 'log', 'convertResponseToSaveCache'])
            ->setConstructorArgs([$loggerMock, $oauth2])
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
        $producers = $this->sut->fetchByNamePrefix('sa',  ProducersRepository::$fieldsAll, 5);

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
        $producers = $this->sut->fetchByIds([12,32,54,345,43], ProducersAsyncRepository::$fieldsAll);

        $this->assertCount(5, $producers);
        /** @var Producer $producer */
        $producer = $producers->getItem(0);
        $this->assertEquals('samsung', $producer->getId());
        $this->assertEquals('Samsung', $producer->getName());
        $this->assertEquals('/producent:samsung.html', $producer->getProductsUrl());
    }

    /**
     * @param $name
     * @return \stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/fixtures/Repository/ProducersRepositoryTest/' . $name . '.json'));
    }
}