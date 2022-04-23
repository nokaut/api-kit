<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.05.2014
 * Time: 12:43
 */

namespace Nokaut\ApiKit\Repository;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Nokaut\ApiKit\Collection\Categories;
use Nokaut\ApiKit\Config;
use Nokaut\ApiKit\Entity\Category;
use Nokaut\ApiKit\Entity\Category\Path;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use stdClass;


class CategoriesRepositoryTest extends TestCase
{

    /**
     * @var CategoriesRepository
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
     * @return stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/fixtures/Repository/CategoriesRepositoryTest/' . $name . '.json'));
    }
}
