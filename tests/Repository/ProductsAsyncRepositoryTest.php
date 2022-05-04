<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 24.09.2014
 * Time: 11:08
 */

namespace Nokaut\ApiKit\Repository;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\ProductsFetch;
use Nokaut\ApiKit\Config;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use stdClass;


class ProductsAsyncRepositoryTest extends TestCase
{
    /**
     * @var ProductsAsyncRepository
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
            ->setMethods(['convertResponse', 'getClient', 'log', 'logMulti', 'convertResponseToSaveCache'])
            ->getMock();

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
     * @return stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/fixtures/Repository/ProductsRepositoryTest/' . $name . '.json'));
    }
} 