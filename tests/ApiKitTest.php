<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 04.07.2014
 * Time: 10:11
 */

namespace Nokaut\ApiKit;


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

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testValidateAndOverrideConfig()
    {
        $config = new Config();
        $this->cut->getProductsRepository($config);
    }
}