<?php
/**
 * Created by PhpStorm.
 * User: dwilkiewicz
 * Date: 11.09.2014
 * Time: 13:28
 */

namespace Nokaut\ApiKit\Repository;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Config;
use Nokaut\ApiKit\Converter\ProductConverter;
use Nokaut\ApiKit\Entity\Product;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use stdClass;


class ProductsRepositoryTest extends TestCase
{
    /**
     * @var ProductsRepository
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

        $this->sut = new ProductsRepository($config, $this->clientApiMock);
    }

    public function testFetchProducts()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture('testFetchProducts')));

        /** @var Products $products */
        $products = $this->sut->fetchProducts(2, ProductsRepository::$fieldsForList);
        $this->assertCount(2, $products);
    }

    public function testFetchProductsByProducerName()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture('testFetchProducts')));

        /** @var Products $products */
        $products = $this->sut->fetchProductsByProducerName('Sony', 2, ProductsRepository::$fieldsForList);
        $this->assertCount(2, $products);
    }

    public function testFetchProductsByCategory()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture('testFetchProducts')));

        /** @var Products $products */
        $products = $this->sut->fetchProductsByCategory(array(1), 2, ProductsRepository::$fieldsForList);
        $this->assertCount(2, $products);
    }

    public function testFetchProductsByUrl()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture('testFetchProducts')));

        /** @var Products $products */
        $products = $this->sut->fetchProductsByUrl('/laptopy', ProductsRepository::$fieldsForList, 2);
        $this->assertCount(2, $products);
    }

    public function testFetchProductsByUrlWithQuality()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture('testFetchProducts')));

        /** @var Products $products */
        $products = $this->sut->fetchProductsByUrl('/laptopy', ProductsRepository::$fieldsForList, 2, 60);
        $this->assertCount(2, $products);
    }

    public function testFetchProductsWithBestOfferByUrl()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture('testFetchProducts')));

        /** @var Products $products */
        $products = $this->sut->fetchProductsWithBestOfferByUrl('/laptopy', ProductsRepository::$fieldsForList, 2);
        $this->assertCount(2, $products);
    }

    public function testFetchCountProductsByPhrase()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture('testFetchProducts')));

        $count = $this->sut->fetchCountProductsByPhrase('laptopy');
        $this->assertEquals(3135, $count);
    }

    public function testFetchProductById()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture('testFetchProduct')));

        $id = '50fe74782da47ccd9d000156';

        /** @var Product $product */
        $product = $this->sut->fetchProductById($id, ProductsRepository::$fieldsForProductPage);
        $this->assertEquals($id, $product->getId());
    }

    public function testFetchProductByUrl()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture('testFetchProduct')));

        $url = 'karty-pamieci/sandisk-extreme-pro-sdhc-uhs-i-8-gb-do-95-90-mb-s-60930d026db577f93b98537bbb2f1219';

        /** @var Product $product */
        $product = $this->sut->fetchProductByUrl($url, ProductsRepository::$fieldsForProductPage);
        $this->assertEquals($url, $product->getUrl());
    }

    public function testFetchSimilarProductsWithHigherPrice()
    {
        $converter = new ProductConverter();
        $product = $converter->convert($this->getJsonFixture('testFetchProductForList'));

        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture('testFetchProducts')));

        /** @var Products $products */
        $products = $this->sut->fetchSimilarProductsWithHigherPrice($product, 2, ProductsRepository::$fieldsForProductPage);
        $this->assertCount(2, $products);
    }

    public function testFetchSimilarProductsWithLowerPrice()
    {
        $converter = new ProductConverter();
        /** @var Product $product */
        $product = $converter->convert($this->getJsonFixture('testFetchProductForList'));

        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture('testFetchProducts')));

        /** @var Products $products */
        $products = $this->sut->fetchSimilarProductsWithLowerPrice($product, 2, ProductsRepository::$fieldsForProductPage);
        $this->assertCount(2, $products);
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
 