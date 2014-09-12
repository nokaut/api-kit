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
        $this->clientApiMock = $this->getMock('Nokaut\ApiKit\ClientApi\ClientApiInterface', array('send', 'sendMulti'));

        $this->sut = new OffersRepository("http://32213:454/api/v2/", $this->clientApiMock);
    }

    public function testFetchOffersByProductId()
    {
        $this->clientApiMock->expects($this->once())->method('send')
            ->will($this->returnValue($this->getJsonFixture(__FUNCTION__)));

        $productId = '50fe74782da47ccd9d000156';

        /** @var Offers $offers */
        $offers = $this->sut->fetchOffersByProductId($productId, OffersRepository::$fieldsAll);
        $this->assertCount(9, $offers);
        $this->assertEquals($offers->getMetadata()->getTotal(), count($offers));
        $this->assertEquals($productId, $offers->getLast()->getPatternId());
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
 