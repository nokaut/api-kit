<?php

namespace Nokaut\ApiKit\Repository;


use Nokaut\ApiKit\ClientApi\Rest\Fetch\ProducersFetch;
use Nokaut\ApiKit\Collection\Producers;
use Nokaut\ApiKit\Config;
use Nokaut\ApiKit\Entity\Producer;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

class ProducersAsyncRepositoryTest extends PHPUnit_Framework_TestCase
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
            array('convertResponse', 'getClient', 'log', 'logMulti', 'convertResponseToSaveCache'),
            array($loggerMock, $oauth2)
        );

        $this->clientApiMock->expects($this->any())->method('getClient')
            ->will($this->returnValue($client));

        $config = new Config();
        $config->setCache($cacheMock);
        $config->setLogger($loggerMock);
        $config->setApiUrl("http://32213:454/api/v2/");

        $this->sut = new ProducersAsyncRepository($config, $this->clientApiMock);
    }

    public function testFetchByNamePrefix()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture('producers')));

        /** @var ProducersFetch $producersFetch */
        $producersFetch = $this->sut->fetchByNamePrefix('sa',  ProducersAsyncRepository::$fieldsAll, 5);
        $this->sut->fetchAllAsync();

        /** @var Producers $producers */
        $producers = $producersFetch->getResult();

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

        /** @var ProducersFetch $producersFetch */
        $producersFetch = $this->sut->fetchByIds([12,32,54,345,43], ProducersAsyncRepository::$fieldsAll);
        $this->sut->fetchAllAsync();

        /** @var Producers $producers */
        $producers = $producersFetch->getResult();

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