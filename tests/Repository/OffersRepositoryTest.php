<?php
/**
 * Created by PhpStorm.
 * User: dwilkiewicz
 * Date: 12.09.2014
 * Time: 09:10
 */

namespace Nokaut\ApiKit\Repository;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Nokaut\ApiKit\Collection\Offers;
use Nokaut\ApiKit\Config;
use Nokaut\ApiKit\Entity\Offer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use stdClass;


class OffersRepositoryTest extends TestCase
{
    /**
     * @var OffersRepository
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

        $this->sut = new OffersRepository($config, $this->clientApiMock);
    }

    public function testFetchOffersByProductId()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture(__FUNCTION__)));

        $productId = '50fe74782da47ccd9d000156';

        /** @var Offers $offers */
        $offers = $this->sut->fetchOffersByProductId($productId, OffersRepository::$fieldsAll);
        $this->assertCount(9, $offers);
        $this->assertEquals($offers->getMetadata()->getTotal(), count($offers));
        $this->assertEquals($productId, $offers->getLast()->getPatternId());
    }

    public function testFetchOffersByShopId()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture('testFetchOffersByProductId')));

        $shopId = 632;

        /** @var Offers $offers */
        $offers = $this->sut->fetchOffersByShopId($shopId, OffersRepository::$fieldsAll);
        $this->assertCount(9, $offers);
        $this->assertEquals($offers->getMetadata()->getTotal(), count($offers));
        $this->assertEquals($shopId, $offers->getLast()->getShopId());
    }

    public function testFetchOfferById()
    {
        $this->clientApiMock->expects($this->once())->method('convertResponse')
            ->will($this->returnValue($this->getJsonFixture(__FUNCTION__)));

        $id = '60930d026db577f93b98537bbb2f1219';

        /** @var Offer $offer */
        $offer = $this->sut->fetchOfferById($id, OffersRepository::$fieldsAll);
        $this->assertInstanceOf('Nokaut\ApiKit\Entity\Offer', $offer);
        $this->assertEquals($id, $offer->getId());
    }

    /**
     * @param $name
     * @return stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/fixtures/Repository/OffersRepositoryTest/' . $name . '.json'));
    }
}
 