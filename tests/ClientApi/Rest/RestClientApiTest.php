<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.10.2014
 * Time: 11:20
 */

namespace Nokaut\ApiKit\ClientApi\Rest;


use CommerceGuys\Guzzle\Plugin\Oauth2\Oauth2Plugin;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\Fetch;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\Fetches;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\ProductsFetch;

class RestClientApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Nokaut\ApiKit\ClientApi\Rest\Exception\FatalResponseException
     */
    public function testSendWithRetry()
    {
        $oauth2 = $this->prepareOauth();
        $loggerMock = $this->getMock('Psr\Log\LoggerInterface');

        $request = $this->getMockBuilder('\Guzzle\Http\Message\Request')->disableOriginalConstructor()->getMock();
        $response = $this->getMockBuilder('\Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
        $response->expects($this->any())->method('getStatusCode')->will($this->returnValue(502));

        $exceptionFromApi = new \Guzzle\Http\Exception\BadResponseException();
        $exceptionFromApi->setRequest($request);
        $exceptionFromApi->setResponse($response);
        $client = $this->getMockBuilder('\Guzzle\Http\Client')->disableOriginalConstructor()->getMock();
        $client->expects($this->exactly(2))->method('send')->will($this->throwException($exceptionFromApi));

        $cutMock = $this->prepareCut($loggerMock, $oauth2, $client);

        $fetch = $this->prepareFetch();
        $cutMock->send($fetch);

    }

    public function testSendWithRetryAndSecondSuccessful()
    {
        $oauth2 = $this->prepareOauth();
        $loggerMock = $this->getMock('Psr\Log\LoggerInterface');

        $request = $this->getMockBuilder('\Guzzle\Http\Message\Request')->disableOriginalConstructor()->getMock();
        $response = $this->getMockBuilder('\Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
        $response->expects($this->any())->method('getStatusCode')->will($this->returnValue(502));
        $responseSuccess = $this->getMockBuilder('\Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
        $responseSuccess->expects($this->any())->method('getStatusCode')->will($this->returnValue(200));
        $responseSuccess->expects($this->any())->method('getBody')->will($this->returnValue("{}"));

        $exceptionFromApi = new \Guzzle\Http\Exception\BadResponseException();
        $exceptionFromApi->setRequest($request);
        $exceptionFromApi->setResponse($response);
        $client = $this->getMockBuilder('\Guzzle\Http\Client')->disableOriginalConstructor()->getMock();
        $client->expects($this->exactly(2))
            ->method('send')
            ->will(
                $this->onConsecutiveCalls($this->throwException($exceptionFromApi), $this->returnValue($responseSuccess))
            );

        $cutMock = $this->prepareCut($loggerMock, $oauth2, $client);

        $fetch = $this->prepareFetch();
        $cutMock->send($fetch);

    }

    public function testSendCorrectResponse()
    {
        $oauth2 = $this->prepareOauth();
        $loggerMock = $this->getMock('Psr\Log\LoggerInterface');

        $response = $this->getMockBuilder('\Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
        $response->expects($this->any())->method('getStatusCode')->will($this->returnValue(200));
        $response->expects($this->any())->method('getBody')->will($this->returnValue("{}"));

        $client = $this->getMockBuilder('\Guzzle\Http\Client')->disableOriginalConstructor()->getMock();
        $client->expects($this->exactly(1))->method('send')->will($this->returnValue($response));

        $cutMock = $this->prepareCut($loggerMock, $oauth2, $client);

        $fetch = $this->prepareFetch();
        $cutMock->send($fetch);

    }

    /**
     * @expectedException \Nokaut\ApiKit\ClientApi\Rest\Exception\FatalResponseException
     */
    public function testSendWithIncorrectResponse()
    {
        $oauth2 = $this->prepareOauth();
        $loggerMock = $this->getMock('Psr\Log\LoggerInterface');

        $request = $this->getMockBuilder('\Guzzle\Http\Message\Request')->disableOriginalConstructor()->getMock();
        $response = $this->getMockBuilder('\Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
        $response->expects($this->any())->method('getStatusCode')->will($this->returnValue(500));

        $exceptionFromApi = new \Guzzle\Http\Exception\BadResponseException();
        $exceptionFromApi->setRequest($request);
        $exceptionFromApi->setResponse($response);

        $client = $this->getMockBuilder('\Guzzle\Http\Client')->disableOriginalConstructor()->getMock();
        $client->expects($this->exactly(1))->method('send')->will($this->throwException($exceptionFromApi));

        $cutMock = $this->prepareCut($loggerMock, $oauth2, $client);

        $fetch = $this->prepareFetch();
        $cutMock->send($fetch);

    }

    public function testSendMultiWithRetry()
    {
        $oauth2 = $this->prepareOauth();
        $loggerMock = $this->getMock('Psr\Log\LoggerInterface');

        $response = $this->getMockBuilder('\Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
        $response->expects($this->any())->method('getStatusCode')->will($this->returnValue(502));

        $client = $this->getMockBuilder('\Guzzle\Http\Client')->disableOriginalConstructor()->getMock();
        $client->expects($this->exactly(2))->method('send')->will($this->returnValue(array($response, $response)));

        $cutMock = $this->prepareCut($loggerMock, $oauth2, $client);

        $fetches = $this->prepareFetches();
        $cutMock->sendMulti($fetches);

    }

    public function testSendMultiWithoutRetry()
    {
        $oauth2 = $this->prepareOauth();
        $loggerMock = $this->getMock('Psr\Log\LoggerInterface');

        $response = $this->getMockBuilder('\Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
        $response->expects($this->any())->method('getStatusCode')->will($this->returnValue(200));
        $response->expects($this->any())->method('getBody')->will($this->returnValue("{}"));

        $client = $this->getMockBuilder('\Guzzle\Http\Client')->disableOriginalConstructor()->getMock();
        $client->expects($this->exactly(1))->method('send')->will($this->returnValue(array($response, $response)));

        $cutMock = $this->clientApiMock = $this->getMock(
            'Nokaut\ApiKit\ClientApi\Rest\RestClientApi',
            array('getClient', 'logMulti'),
            array($loggerMock, $oauth2)
        );
        $cutMock->expects($this->any())->method('getClient')
            ->will($this->returnValue($client));

        $fetches = $this->prepareFetches();
        $cutMock->sendMulti($fetches);

    }

    /**
     * @return Oauth2Plugin
     */
    protected function prepareOauth()
    {
        $oauth2 = new Oauth2Plugin();
        $accessToken = array(
            'access_token' => '1111'
        );
        $oauth2->setAccessToken($accessToken);
        return $oauth2;
    }

    /**
     * @param $loggerMock
     * @param $oauth2
     * @param $client
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function prepareCut($loggerMock, $oauth2, $client)
    {
        $cutMock = $this->clientApiMock = $this->getMock(
            'Nokaut\ApiKit\ClientApi\Rest\RestClientApi',
            array('getClient', 'logMulti', 'log'),
            array($loggerMock, $oauth2)
        );
        $cutMock->expects($this->any())->method('getClient')
            ->will($this->returnValue($client));
        return $cutMock;
    }

    /**
     * @return Fetches
     */
    protected function prepareFetches()
    {
        $fetch = $this->prepareFetch();
        $fetches = new Fetches();
        $fetches->addFetch($fetch);
        return $fetches;
    }

    /**
     * @return ProductsFetch
     */
    protected function prepareFetch()
    {
        $cacheMock = $this->getMock('Nokaut\ApiKit\Cache\CacheInterface');
        $queryMock = $this->getMockBuilder('Nokaut\ApiKit\ClientApi\Rest\Query\ProductsQuery')->disableOriginalConstructor()->getMock();
        $converterMock = $this->getMockBuilder('Nokaut\ApiKit\Converter\ConverterInterface')->getMock();
        return new Fetch($queryMock, $converterMock, $cacheMock);
    }
} 