<?php
/**
 * Created by PhpStorm.
 * User: dwilkiewicz
 * Date: 11.09.2014
 * Time: 13:28
 */

namespace Nokaut\ApiKit\Repository;

use CommerceGuys\Guzzle\Plugin\Oauth2\Oauth2Plugin;
use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Config;
use Nokaut\ApiKit\Entity\Product;
use Nokaut\ApiKit\Converter\ProductConverter;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

class ProductsRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ProductsRepository
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
        $cacheMock = $this->getMock('Nokaut\ApiKit\Cache\CacheInterface');
        $loggerMock = $this->getMock('Psr\Log\LoggerInterface');
        $client = $this->getMockBuilder('\Guzzle\Http\Client')->disableOriginalConstructor()->getMock();
        $this->clientApiMock = $this->getMock(
            'Nokaut\ApiKit\ClientApi\Rest\RestClientApi',
            array('convertResponse', 'getClient', 'log'),
            array($loggerMock, $oauth2)
        );
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
     * @return \stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/fixtures/Repository/ProductsRepositoryTest/' . $name . '.json'));
    }
}
 