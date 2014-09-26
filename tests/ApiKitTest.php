<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 04.07.2014
 * Time: 10:11
 */

namespace Nokaut\ApiKit;


use Guzzle\Http\Message\Response;
use PHPUnit_Framework_TestCase;

class ApiKitTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ApiKit
     */
    private $cut;

    public function setUp()
    {
        $config = new Config();
        $config->setApiUrl("mock");
        $config->setApiAccessToken("mock");
        $this->cut = new ApiKit($config);
    }

    public function testGetProductsRepository()
    {
        $productsRepository = $this->cut->getProductsRepository();

        $this->assertInstanceOf("Nokaut\\ApiKit\\Repository\\ProductsRepository", $productsRepository);
    }

    public function testGetCategoriesRepository()
    {
        $categoriesRepository = $this->cut->getCategoriesRepository();

        $this->assertInstanceOf("Nokaut\\ApiKit\\Repository\\CategoriesRepository", $categoriesRepository);
    }

    public function testGetOffersRepository()
    {
        $offersRepository = $this->cut->getOffersRepository();

        $this->assertInstanceOf("Nokaut\\ApiKit\\Repository\\OffersRepository", $offersRepository);
    }

    public function testGetProductsAsyncRepository()
    {
        $productsAsyncRepository = $this->cut->getProductsAsyncRepository();

        $this->assertInstanceOf("Nokaut\\ApiKit\\Repository\\ProductsAsyncRepository", $productsAsyncRepository);
    }

    public function testGetCategoriesAsyncRepository()
    {
        $categoriesAsyncRepository = $this->cut->getCategoriesAsyncRepository();

        $this->assertInstanceOf("Nokaut\\ApiKit\\Repository\\CategoriesAsyncRepository", $categoriesAsyncRepository);
    }

    public function testGetOffersAsyncRepository()
    {
        $offersAsyncRepository = $this->cut->getOffersAsyncRepository();

        $this->assertInstanceOf("Nokaut\\ApiKit\\Repository\\OffersAsyncRepository", $offersAsyncRepository);
    }

    public function testAsyncOverrideCache()
    {
        $cacheMock1 = $this->getMock('Nokaut\ApiKit\Cache\CacheInterface');
        $cacheMock1->expects($this->once())->method('get')->will($this->returnValue($this->getResponseFixture('testOverrideCache1')));
        $config1 = new Config();
        $config1->setApiUrl("mock");
        $config1->setApiAccessToken("mock");
        $config1->setCache($cacheMock1);

        $cut = new ApiKit($config1);

        $cacheMock2 = $this->getMock('Nokaut\ApiKit\Cache\CacheInterface');
        $cacheMock2->expects($this->once())->method('get')->will($this->returnValue($this->getResponseFixture('testOverrideCache2')));
        $config2 = new Config();
        $config2->setApiUrl("mock");
        $config2->setApiAccessToken("mock");
        $config2->setCache($cacheMock2);

        $categoriesAsyncRepositoryWithOverrideConfig = $cut->getCategoriesAsyncRepository($config2);
        $categoriesAsyncRepository = $cut->getCategoriesAsyncRepository();
        $categoryAsync2 = $categoriesAsyncRepositoryWithOverrideConfig->fetchById(2);
        $categoryAsync1 = $categoriesAsyncRepository->fetchById(1);
        $categoriesAsyncRepositoryWithOverrideConfig->fetchAllAsync();

        $this->assertEquals(687, $categoryAsync1->getResult()->getId());
        $this->assertEquals(688, $categoryAsync2->getResult()->getId());
    }

    public function testOverrideCache()
    {
        $cacheMock1 = $this->getMock('Nokaut\ApiKit\Cache\CacheInterface');
        $cacheMock1->expects($this->once())->method('get')->will($this->returnValue($this->getResponseFixture('testOverrideCache1')));
        $config1 = new Config();
        $config1->setApiUrl("mock");
        $config1->setApiAccessToken("mock");
        $config1->setCache($cacheMock1);

        $cut = new ApiKit($config1);

        $cacheMock2 = $this->getMock('Nokaut\ApiKit\Cache\CacheInterface');
        $cacheMock2->expects($this->once())->method('get')->will($this->returnValue($this->getResponseFixture('testOverrideCache2')));
        $config2 = new Config();
        $config2->setApiUrl("mock");
        $config2->setApiAccessToken("mock");
        $config2->setCache($cacheMock2);

        $categoriesRepositoryWithOverrideConfig = $cut->getCategoriesRepository($config2);
        $categoriesRepository = $cut->getCategoriesRepository();
        $category2 = $categoriesRepositoryWithOverrideConfig->fetchById(2);
        $category1 = $categoriesRepository->fetchById(1);

        $this->assertEquals(687, $category1->getId());
        $this->assertEquals(688, $category2->getId());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testValidateAndOverrideConfig()
    {
        $config = new Config();
        $this->cut->getProductsRepository($config);
    }

    /**
     * @param $name
     * @return Response
     */
    private function getResponseFixture($name)
    {
        $response = new Response(200);
        $response->setBody(file_get_contents(__DIR__ . '/fixtures/ApiKit/' . $name . '.json'));
        return serialize($response);
    }
}