<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.05.2014
 * Time: 12:43
 */

namespace Nokaut\ApiKit\Repository;


use CommerceGuys\Guzzle\Plugin\Oauth2\Oauth2Plugin;
use Nokaut\ApiKit\Collection\Categories;
use Nokaut\ApiKit\Config;
use Nokaut\ApiKit\Entity\Category;
use Nokaut\ApiKit\Entity\Category\Path;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

class CategoriesRepositoryTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var CategoriesRepository
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

        $this->sut = new CategoriesRepository($config, $this->clientApiMock);
    }

    public function testFetchByParentId()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture(__FUNCTION__)));

        /** @var Categories $categories */
        $categories = $this->sut->fetchByParentId(686);

        $this->assertCount(1, $categories);
        /** @var Category $category */
        $category = $categories->getItem(0);
        $this->assertEquals(687, $category->getId());
        $this->assertEquals(0.24, $category->getCpcValue());
        $this->assertEquals(2, $category->getDepth());
        $this->assertEquals(null, $category->getIsAdult());
        $this->assertEquals(true, $category->getIsVisible());
        $this->assertEquals("Telefony komórkowe", $category->getTitle());
        $this->assertEquals(686, $category->getParentId());
        $this->assertEquals("07b3eb9f5a5f2b1ff4099a8c19aa6288", $category->getPhotoId());
        $this->assertEquals(0, $category->getSubcategoryCount());
        $this->assertEquals("/telefony-komorkowe", $category->getUrl());
        $this->assertEquals("picture", $category->getViewType());

        $path = $category->getPath();
        $this->assertCount(2, $path);
        /** @var Path $pathRow */
        $pathRow = $path[0];
        $this->assertEquals(686, $pathRow->getId());
        $this->assertEquals("/telefony-i-akcesoria", $pathRow->getUrl());
        $this->assertEquals("Telefony i akcesoria", $pathRow->getTitle());
        $pathRow = $path[1];
        $this->assertEquals(687, $pathRow->getId());
        $this->assertEquals("/telefony-komorkowe", $pathRow->getUrl());
        $this->assertEquals("Telefony komórkowe", $pathRow->getTitle());
    }

    public function testFetchById()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')->withAnyParameters()
            ->will($this->returnValue($this->getJsonFixture(__FUNCTION__)));

        /** @var Category $category */
        $category = $this->sut->fetchById(687);

        $this->assertEquals(687, $category->getId());
        $this->assertEquals(0.24, $category->getCpcValue());
        $this->assertEquals(2, $category->getDepth());
        $this->assertEquals(null, $category->getIsAdult());
        $this->assertEquals(true, $category->getIsVisible());
        $this->assertEquals("Telefony komórkowe", $category->getTitle());
        $this->assertEquals(686, $category->getParentId());
        $this->assertEquals("07b3eb9f5a5f2b1ff4099a8c19aa6288", $category->getPhotoId());
        $this->assertEquals(0, $category->getSubcategoryCount());
        $this->assertEquals("/telefony-komorkowe", $category->getUrl());
        $this->assertEquals("picture", $category->getViewType());

        $path = $category->getPath();
        $this->assertCount(2, $path);
        /** @var Path $pathRow */
        $pathRow = $path[0];
        $this->assertEquals(686, $pathRow->getId());
        $this->assertEquals("/telefony-i-akcesoria", $pathRow->getUrl());
        $this->assertEquals("Telefony i akcesoria", $pathRow->getTitle());
        $pathRow = $path[1];
        $this->assertEquals(687, $pathRow->getId());
        $this->assertEquals("/telefony-komorkowe", $pathRow->getUrl());
        $this->assertEquals("Telefony komórkowe", $pathRow->getTitle());
    }

    public function testFetchByParentIdWithChildren()
    {
        $categoriesWithChildrenFromApi = $this->getJsonFixture(__FUNCTION__);
        $this->clientApiMock->expects($this->once())->method('convertResponse')->withAnyParameters()
            ->will($this->returnValue($categoriesWithChildrenFromApi));

        /** @var Category[] $categories */
        $categories = $this->sut->fetchByParentIdWithChildren(687);

        $this->assertCount(7, $categories);

        $allCountCategories = 0;
        foreach ($categories as $category) {
            ++$allCountCategories;
            if ($category->getChildren()) {
                $this->assertParentId($category, $allCountCategories);
            }
        }
        $this->assertEquals(count($categoriesWithChildrenFromApi->categories), $allCountCategories);
    }

    private function assertParentId(Category $category, &$allCountCategories)
    {
        foreach ($category->getChildren() as $child) {
            ++$allCountCategories;
            $this->assertEquals($category->getId(), $child->getParentId());
            if ($child->getChildren()) {
                $this->assertParentId($child, $allCountCategories);
            }
        }
    }

    /**
     * @param $name
     * @return \stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/fixtures/Repository/CategoriesRepositoryTest/' . $name . '.json'));
    }
}
