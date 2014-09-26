<?php
/**
 * Created by PhpStorm.
 * User: dwilkiewicz
 * Date: 12.09.2014
 * Time: 09:10
 */

namespace Nokaut\ApiKit\Repository;

use CommerceGuys\Guzzle\Plugin\Oauth2\Oauth2Plugin;
use Nokaut\ApiKit\Collection\Offers;
use Nokaut\ApiKit\Config;
use Nokaut\ApiKit\Entity\Offer;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

class OffersRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var OffersRepository
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
     * @return \stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/fixtures/Repository/OffersRepositoryTest/' . $name . '.json'));
    }
}
 