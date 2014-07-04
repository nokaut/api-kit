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

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testValidateAndOverrideConfig()
    {
        $config = new Config();
        $this->cut->getProductsRepository($config);
    }
}